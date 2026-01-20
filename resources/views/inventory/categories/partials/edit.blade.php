<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="editCategoryForm">
                    <input type="hidden" name="category_id">

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" name="slug">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Filter Tag</label>
                        <input type="text" class="form-control" name="filter_tag">
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active">
                        <label class="form-check-label">Active</label>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="updateCategoryBtn">Update</button>
            </div>

        </div>
    </div>
</div>
