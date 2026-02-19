let productCache = [];
let categoryCache = [];

const PRODUCT_API = '/api/inventory/products';
const CATEGORY_API = '/api/inventory/categories';

document.addEventListener('DOMContentLoaded', () => {

    loadCategories();
    loadProducts();

    document.getElementById('saveProductBtn')
        ?.addEventListener('click', submitCreateProduct);

    document.getElementById('updateProductBtn')
        ?.addEventListener('click', submitUpdateProduct);
});

/* ===============================
   LOAD DATA
================================ */

function loadProducts() {
    fetch(PRODUCT_API)
        .then(res => res.json())
        .then(data => {
            productCache = Array.isArray(data) ? data : (data.data ?? []);
            renderProducts(productCache);
        });
}

function loadCategories() {
    fetch(CATEGORY_API)
        .then(res => res.json())
        .then(data => {
            categoryCache = Array.isArray(data) ? data : (data.data ?? []);
            populateCategoryDropdowns();
        });
}

function populateCategoryDropdowns() {

    const createSelect = document.getElementById('productCategorySelect');
    const editSelect = document.getElementById('editProductCategory');

    if (createSelect) createSelect.innerHTML = '';
    if (editSelect) editSelect.innerHTML = '';

    categoryCache.forEach(cat => {
        const option = `<option value="${cat.id}">${escapeHtml(cat.name)}</option>`;

        if (createSelect) createSelect.insertAdjacentHTML('beforeend', option);
        if (editSelect) editSelect.insertAdjacentHTML('beforeend', option);
    });
}

/* ===============================
   RENDER
================================ */

function renderProducts(products) {

    const tbody = document.getElementById('productTableBody');
    const mobile = document.getElementById('productMobileList');

    if (tbody) tbody.innerHTML = '';
    if (mobile) mobile.innerHTML = '';

    products.forEach(product => {

        const row = `
            <tr data-id="${product.id}">
                <td>${escapeHtml(product.name)}</td>
                <td>${escapeHtml(product.category?.name ?? '-')}</td>
                <td>${escapeHtml(product.sku)}</td>
                <td>${product.is_active ? 'Active' : 'Inactive'}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary btn-edit">Edit</button>
                    <button class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                </td>
            </tr>
        `;

        const card = `
            <div class="card mb-2" data-id="${product.id}">
                <div class="card-body">
                    <h5>${escapeHtml(product.name)}</h5>
                    <p><strong>Category:</strong> ${escapeHtml(product.category?.name ?? '-')}</p>
                    <p><strong>SKU:</strong> ${escapeHtml(product.sku)}</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary w-50 btn-edit">Edit</button>
                        <button class="btn btn-sm btn-outline-danger w-50 btn-delete">Delete</button>
                    </div>
                </div>
            </div>
        `;

        if (tbody) tbody.insertAdjacentHTML('beforeend', row);
        if (mobile) mobile.insertAdjacentHTML('beforeend', card);
    });
}

/* ===============================
   CREATE
================================ */

function submitCreateProduct() {

    const form = document.getElementById('createProductForm');
    const formData = new FormData(form);

    formData.set('is_active',
        form.querySelector('[name="is_active"]')?.checked ? 1 : 0
    );

    fetch(PRODUCT_API, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData
    })
        .then(res => res.json())
        .then(() => {
            bootstrap.Modal.getInstance(
                document.getElementById('createProductModal')
            )?.hide();

            form.reset();
            loadProducts();
        });
}

/* ===============================
   EDIT
================================ */

document.addEventListener('click', function (e) {

    if (e.target.classList.contains('btn-edit')) {
        const id = e.target.closest('[data-id]').dataset.id;
        openEditModal(id);
    }

    if (e.target.classList.contains('btn-delete')) {
        const id = e.target.closest('[data-id]').dataset.id;
        deleteProduct(id);
    }
});

function openEditModal(id) {

    const product = productCache.find(p => p.id == id);
    if (!product) return;

    document.getElementById('editProductId').value = product.id;
    document.getElementById('editProductName').value = product.name;
    document.getElementById('editProductSlug').value = product.slug ?? '';
    document.getElementById('editProductImage').value = product.image ?? '';
    document.getElementById('editProductDescription').value = product.description ?? '';
    document.getElementById('editProductCategory').value = product.category_id;
    document.getElementById('editProductActive').checked = product.is_active;

    new bootstrap.Modal(document.getElementById('editProductModal')).show();
}

function submitUpdateProduct() {

    const id = document.getElementById('editProductId').value;
    const form = document.getElementById('editProductForm');
    const formData = new FormData(form);


    formData.set('is_active',
        form.querySelector('[name="is_active"]')?.checked ? 1 : 0
    );

        formData.append('_method','PUT');
   fetch(`${PRODUCT_API}/${id}`, {
    method: 'POST',
    headers: { 'Accept': 'application/json' },
    body: formData
})
.then(async res => {
    const data = await res.json();

    if (!res.ok) throw data;

    return data;
})
.then(() => {
    bootstrap.Modal.getInstance(
        document.getElementById('editProductModal')
    )?.hide();

    loadProducts();
})
.catch(error => {
    if (error.errors) {
        alert(Object.values(error.errors).map(e => e[0]).join('\n'));
    } else {
        alert('Something went wrong');
    }
});

}

/* ===============================
   DELETE
================================ */

function deleteProduct(id) {

    if (!confirm('Are you sure you want to delete this product?')) return;

    fetch(`${PRODUCT_API}/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json' }
    })
        .then(() => loadProducts());
}

/* ===============================
   HELPERS
================================ */

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}
