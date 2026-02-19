@extends('inventory.layout')

@section('title', 'Products')

@section('content')

<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Products</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
            + Add Product
        </button>
    </div>

    <!-- Desktop Table -->
    <div class="card d-none d-md-block">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>SKU</th>
                        <th>Status</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    <!-- JS will populate -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile View -->
    <div class="d-md-none mt-3" id="productMobileList">
        <!-- JS will populate -->
    </div>

</div>

<!-- Create Modal -->
@include('inventory.products._create_modal')

<!-- Edit Modal -->
@include('inventory.products._edit_modal')

@endsection


@push('scripts')
<script src="{{ asset('js/inventory/products.js') }}"></script>
@endpush
