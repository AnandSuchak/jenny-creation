<div class="modal fade" id="variantsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title">
                    Manage Variants
                </h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- Hidden Product ID -->
                <input type="hidden" id="currentProductId">

                <!-- ===============================
                     CREATE / UPDATE FORM
                ================================ -->
                <div class="card mb-4">
                    <div class="card-body">

                        <form id="variantForm">
                                <input type="hidden" id="variantId" name="variant_id">
                            <input type="hidden" id="editingVariantId" value="">
                            <div class="row g-3 align-items-end">

                                <!-- Variant Name -->
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Variant Name
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           name="variant_name"
                                           required>
                                </div>

                                <!-- Cost Price -->
                                <div class="col-md-2">
                                    <label class="form-label">
                                        Cost Price
                                    </label>
                                    <input type="number"
                                           step="0.01"
                                           class="form-control"
                                           name="cost_price"
                                           placeholder="0.00">
                                </div>

                                <!-- Selling Price -->
                                <div class="col-md-2">
                                    <label class="form-label">
                                        Selling Price
                                    </label>
                                    <input type="number"
                                           step="0.01"
                                           class="form-control"
                                           name="selling_price"
                                           required>
                                </div>

                                <!-- Barcode -->
                                <div class="col-md-3">
                                    <label class="form-label">
                                        Barcode (optional)
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           name="barcode"
                                           placeholder="Auto generated if empty">
                                </div>

                                <!-- Save Button -->
                                <div class="col-md-2 d-grid">
                                    <button type="button"
                                            class="btn btn-success"
                                            id="saveVariantBtn">
                                        Add Variant
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>
                </div>

                <!-- ===============================
                     VARIANT LIST TABLE
                ================================ -->
                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Cost</th>
                                <th>Selling</th>
                                <th>Barcode</th>
                                
                                <th width="150">Action</th>
                            </tr>
                        </thead>

                        <tbody id="variantTableBody">
                            <!-- JS will render variants here -->
                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>
</div>
