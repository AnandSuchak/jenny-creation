<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editProductForm">

                    <input type="hidden" name="id" id="editProductId">

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="editProductCategory"></select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="editProductName">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug" id="editProductSlug">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="text" class="form-control" name="image" id="editProductImage">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="editProductDescription"></textarea>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="editProductActive">
                        <label class="form-check-label">Active</label>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="updateProductBtn">Update</button>
            </div>

        </div>
    </div>
</div>
