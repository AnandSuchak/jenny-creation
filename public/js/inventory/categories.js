/* =====================================================
   GLOBAL CACHE
===================================================== */
let categoryCache = [];

/* =====================================================
   CONFIG
===================================================== */
const CATEGORY_API = '/api/inventory/categories';

/* =====================================================
   DOM READY
===================================================== */
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('categoryTableBody')) {
        loadCategories();
    }

    const saveBtn = document.getElementById('saveCategoryBtn');
    if (saveBtn) {
        saveBtn.addEventListener('click', submitCreateCategory);
    }

    const updateBtn = document.getElementById('updateCategoryBtn');
    if (updateBtn) {
        updateBtn.addEventListener('click', submitUpdateCategory);
    }
});

/* =====================================================
   LOAD + RENDER
===================================================== */
function loadCategories() {
    fetch(CATEGORY_API)
        .then(response => {
            if (!response.ok) throw new Error('Failed to load categories');
            return response.json();
        })
        .then(data => {
            const categories = Array.isArray(data) ? data : (data.data ?? []);
            categoryCache = categories; // 🔒 CACHE
            renderCategories(categories);
        })
        .catch(error => {
            console.error(error);
            showError('Unable to load categories');
        });
}

function renderCategories(categories) {
    renderDesktopTable(categories);
    renderMobileCards(categories);
}

function renderDesktopTable(categories) {
    const tbody = document.getElementById('categoryTableBody');
    if (!tbody) return;

    tbody.innerHTML = '';

    if (categories.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="text-center text-muted">
                    No categories found
                </td>
            </tr>
        `;
        return;
    }

    categories.forEach(category => {
        tbody.insertAdjacentHTML('beforeend', `
            <tr data-id="${category.id}">
                <td>${escapeHtml(category.name)}</td>
                <td>${escapeHtml(category.slug)}</td>
                <td>${category.filter_tag ?? '-'}</td>
                <td>
                    ${category.is_active
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-secondary">Inactive</span>'}
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-primary btn-edit">Edit</button>
                    <button class="btn btn-sm btn-outline-danger btn-delete">Delete</button>
                </td>
            </tr>
        `);
    });
}

function renderMobileCards(categories) {
    const container = document.getElementById('categoryMobileList');
    if (!container) return;

    container.innerHTML = '';

    if (categories.length === 0) {
        container.innerHTML = `
            <div class="alert alert-secondary text-center">
                No categories available
            </div>
        `;
        return;
    }

    categories.forEach(category => {
        container.insertAdjacentHTML('beforeend', `
            <div class="card mb-2" data-id="${category.id}">
                <div class="card-body">
                    <h5 class="card-title">${escapeHtml(category.name)}</h5>
                    <p class="mb-1"><strong>Slug:</strong> ${escapeHtml(category.slug)}</p>
                    <p class="mb-2">
                        <strong>Status:</strong>
                        ${category.is_active ? 'Active' : 'Inactive'}
                    </p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-primary w-50 btn-edit">Edit</button>
                        <button class="btn btn-sm btn-outline-danger w-50 btn-delete">Delete</button>
                    </div>
                </div>
            </div>
        `);
    });
}

/* =====================================================
   CREATE CATEGORY
===================================================== */
function submitCreateCategory() {
    const form = document.getElementById('createCategoryForm');
    const btn = document.getElementById('saveCategoryBtn');
    if (!form || !btn) return;

    const formData = new FormData(form);
    formData.set('is_active', form.elements.is_active?.checked ? 1 : 0);

    btn.disabled = true;
    btn.innerText = 'Saving...';

    fetch(CATEGORY_API, {
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
                document.getElementById('createCategoryModal')
            )?.hide();

            form.reset();
            loadCategories();
        })
        .catch(handleValidationErrors)
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Save';
        });
}

/* =====================================================
   EDIT CATEGORY
===================================================== */
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-edit')) {
        const wrapper = e.target.closest('[data-id]');
        if (!wrapper) return;
        openEditModal(wrapper.dataset.id);
    }
});

function openEditModal(id) {
    const category = categoryCache.find(c => c.id == id);
    if (!category) {
        alert('Category not found');
        return;
    }

    const form = document.getElementById('editCategoryForm');
    form.elements.category_id.value = category.id;
    form.elements.name.value = category.name;
    form.elements.slug.value = category.slug;
    form.elements.filter_tag.value = category.filter_tag ?? '';
    form.elements.is_active.checked = !!category.is_active;

    new bootstrap.Modal(
        document.getElementById('editCategoryModal')
    ).show();
}

function submitUpdateCategory() {
    const form = document.getElementById('editCategoryForm');
    const btn = document.getElementById('updateCategoryBtn');
    if (!form || !btn) return;

    const id = form.elements.category_id.value;
    if (!id) return;

    const formData = new FormData(form);
    formData.set('is_active', form.elements.is_active.checked ? 1 : 0);

    btn.disabled = true;
    btn.innerText = 'Updating...';
    formData.append('_method', 'PUT');

    fetch(`${CATEGORY_API}/${id}`, {
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
                document.getElementById('editCategoryModal')
            )?.hide();

            loadCategories();
        })
        .catch(handleValidationErrors)
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Update';
        });
}

document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-delete')) {
        const wrapper = e.target.closest('[data-id]');
        if (!wrapper) return;

        const id = wrapper.dataset.id;

        if (!confirm('Are you sure you want to delete this category?')) return;

        deleteCategory(id);
    }
});

function deleteCategory(id) {
    fetch(`${CATEGORY_API}/${id}`, {
        method: 'DELETE',
        headers: { 'Accept': 'application/json' }
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) throw data;
        return data;
    })
    .then(() => {
        loadCategories(); // simple & safe
    })
    .catch(handleValidationErrors);
}


/* =====================================================
   HELPERS
===================================================== */
function handleValidationErrors(error) {
    if (!error || !error.errors) {
        alert('Something went wrong');
        return;
    }
    alert(Object.values(error.errors).map(e => e[0]).join('\n'));
}

function showError(message) {
    alert(message);
}

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}
