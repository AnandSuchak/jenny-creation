/* =========================================================
   GLOBAL STATE
========================================================= */

let productCache = [];
let categoryCache = [];
let currentProductId = null;

const PRODUCT_API = '/api/inventory/products';
const CATEGORY_API = '/api/inventory/categories';
const VARIANT_API = '/api/inventory/variants';


/* =========================================================
   INIT
========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    loadCategories();
    loadProducts();

    document.getElementById('saveProductBtn')
        ?.addEventListener('click', submitCreateProduct);

    document.getElementById('updateProductBtn')
        ?.addEventListener('click', submitUpdateProduct);

    document.getElementById('saveVariantBtn')
        ?.addEventListener('click', submitVariant);

});


/* =========================================================
   LOAD DATA
========================================================= */

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

function loadVariants(productId) {
    fetch(`${VARIANT_API}?product_id=${productId}`)
        .then(res => res.json())
        .then(data => renderVariants(data));
}


/* =========================================================
   RENDER PRODUCTS
========================================================= */

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
                    <button class="btn btn-sm btn-outline-info btn-variants">Variants</button>
                    <button class="btn btn-sm btn-outline-primary btn-edit">Edit</button>
                    <button class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                </td>
            </tr>
        `;

        if (tbody) tbody.insertAdjacentHTML('beforeend', row);
    });
}


/* =========================================================
   PRODUCT CREATE
========================================================= */

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
    .then(handleResponse)
    .then(() => {
        bootstrap.Modal.getInstance(
            document.getElementById('createProductModal')
        )?.hide();

        form.reset();
        loadProducts();
    })
    .catch(showErrors);
}


/* =========================================================
   PRODUCT EDIT
========================================================= */

document.addEventListener('click', function (e) {

    const wrapper = e.target.closest('[data-id]');
    if (!wrapper) return;

    const id = wrapper.dataset.id;

    if (e.target.classList.contains('btn-edit')) {
        openEditModal(id);
    }

    if (e.target.classList.contains('btn-delete')) {
        deleteProduct(id);
    }

    if (e.target.classList.contains('btn-variants')) {
        openVariantModal(id);
    }

    if (e.target.classList.contains('btn-edit-variant')) {
        openVariantEdit(id);
    }

    if (e.target.classList.contains('btn-delete-variant')) {
        deleteVariant(id);
    }
});


function openEditModal(id) {

    const product = productCache.find(p => p.id == id);
    if (!product) return;

    document.getElementById('editProductId').value = product.id;
    document.getElementById('editProductName').value = product.name;
    document.getElementById('editProductSlug').value = product.slug ?? '';
    document.getElementById('editProductDescription').value = product.description ?? '';
    document.getElementById('editProductCategory').value = product.category_id;
    document.getElementById('editProductActive').checked = product.is_active;

    new bootstrap.Modal(
        document.getElementById('editProductModal')
    ).show();
}


function submitUpdateProduct() {

    const id = document.getElementById('editProductId').value;
    const form = document.getElementById('editProductForm');
    const formData = new FormData(form);

    formData.set('is_active',
        form.querySelector('[name="is_active"]')?.checked ? 1 : 0
    );

    formData.append('_method', 'PUT');

    fetch(`${PRODUCT_API}/${id}`, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData
    })
    .then(handleResponse)
    .then(() => {
        bootstrap.Modal.getInstance(
            document.getElementById('editProductModal')
        )?.hide();

        loadProducts();
    })
    .catch(showErrors);
}


function deleteProduct(id) {

    if (!confirm('Delete this product?')) return;

    fetch(`${PRODUCT_API}/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json' }
    })
    .then(() => loadProducts());
}


/* =========================================================
   VARIANTS
========================================================= */

function openVariantModal(productId) {

    currentProductId = productId;

    document.getElementById('currentProductId').value = productId;

    loadVariants(productId);

    new bootstrap.Modal(
        document.getElementById('variantsModal')
    ).show();
}


function renderVariants(variants) {

    const tbody = document.getElementById('variantTableBody');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (variants.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">
                    No variants found
                </td>
            </tr>
        `;
        return;
    }

    variants.forEach(v => {
        tbody.insertAdjacentHTML('beforeend', `
            <tr data-id="${v.id}">
                <td>${escapeHtml(v.variant_name)}</td>
                <td>${v.cost_price}</td>
                <td>${v.selling_price}</td>
                <td>${escapeHtml(v.barcode ?? '')}</td>
                <td>${v.is_active ? 'Active' : 'Inactive'}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary btn-edit-variant">
                        Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger btn-delete-variant">
                        Delete
                    </button>
                </td>
            </tr>
        `);
    });
}


function submitVariant() {

    const form = document.getElementById('variantForm');
    const formData = new FormData(form);
    const variantId = document.getElementById('variantId').value;

    formData.append('product_id', currentProductId);
    formData.set('is_active', 1);

    let url = VARIANT_API;

    if (variantId) {
        url = `${VARIANT_API}/${variantId}`;
        formData.append('_method', 'PUT');
    }

    fetch(url, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData
    })
    .then(handleResponse)
    .then(() => {
        resetVariantForm();
        loadVariants(currentProductId);
    })
    .catch(showErrors);
}


function openVariantEdit(id) {

    const row = document.querySelector(`#variantTableBody tr[data-id="${id}"]`);
    if (!row) return;

    document.getElementById('variantId').value = id;

    document.querySelector('[name="variant_name"]').value = row.children[0].innerText;
    document.querySelector('[name="cost_price"]').value = row.children[1].innerText;
    document.querySelector('[name="selling_price"]').value = row.children[2].innerText;
    document.querySelector('[name="barcode"]').value = row.children[3].innerText;

    const btn = document.getElementById('saveVariantBtn');
    btn.innerText = 'Update Variant';
    btn.classList.remove('btn-success');
    btn.classList.add('btn-warning');
}


function deleteVariant(id) {

    if (!confirm('Delete this variant?')) return;

    fetch(`${VARIANT_API}/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json' }
    })
    .then(() => loadVariants(currentProductId));
}


function resetVariantForm() {

    document.getElementById('variantForm').reset();
    document.getElementById('variantId').value = '';

    const btn = document.getElementById('saveVariantBtn');
    btn.innerText = 'Add Variant';
    btn.classList.remove('btn-warning');
    btn.classList.add('btn-success');
}


/* =========================================================
   HELPERS
========================================================= */

function handleResponse(res) {
    return res.json().then(data => {
        if (!res.ok) throw data;
        return data;
    });
}

function showErrors(error) {
    if (error.errors) {
        alert(Object.values(error.errors).map(e => e[0]).join('\n'));
    } else {
        alert('Something went wrong');
    }
}

function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
}
