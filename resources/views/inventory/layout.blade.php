@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
<div class="container-fluid">

    {{-- Inventory Header --}}
    <div class="row mb-3">
        <div class="col-12">
            <h3 class="fw-bold">Inventory Management</h3>
        </div>
    </div>

    {{-- Inventory Navigation --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="btn-group flex-wrap" role="group">
                <a href="{{ route('inventory.categories') }}" class="btn btn-outline-primary">Categories</a>
                <a href="{{ route('inventory.products') }}" class="btn btn-outline-primary">Products</a>
                <a href="{{ route('inventory.stock') }}" class="btn btn-outline-primary">Stock</a>
            </div>
        </div>
    </div>

    {{-- Inventory Page Content --}}
    <div class="row">
        <div class="col-12">
            @yield('inventory-content')
        </div>
    </div>

</div>
@endsection
