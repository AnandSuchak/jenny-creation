<div class="modal fade" id="createProductModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="createProductForm">

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category_id" id="productCategorySelect">
                            {{-- JS will load categories --}}
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug (optional)</label>
                        <input type="text" class="form-control" name="slug">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image Path</label>
                        <input type="text" class="form-control" name="image">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" checked>
                        <label class="form-check-label">Active</label>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="saveProductBtn">Save</button>
            </div>

        </div>
    </div>
</div>
