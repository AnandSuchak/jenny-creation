@extends('inventory.layout')

@section('title', 'Categories')

@section('inventory-content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Categories</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
        + Add Category
    </button>
</div>

{{-- DESKTOP VIEW --}}
<div class="d-none d-md-block">
    <table class="table table-bordered bg-white">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Filter</th>
                <th>Status</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody id="categoryTableBody">
            {{-- JS will inject rows --}}
        </tbody>
    </table>
</div>

{{-- MOBILE VIEW --}}
<div class="d-block d-md-none" id="categoryMobileList">
    {{-- JS will inject cards --}}
</div>

@include('inventory.categories.partials.create')
@include('inventory.categories.partials.edit')

@push('scripts')
<script src="{{ asset('js/inventory/categories.js') }}"></script>
@endpush

@endsection
