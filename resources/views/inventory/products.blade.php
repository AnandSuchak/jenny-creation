@extends('layouts.app')

@section('content')
<h2>Products</h2>

{{-- ADD PRODUCT --}}
<form method="POST"
      action="/api/inventory/products"
      onsubmit="event.preventDefault(); submitProduct(this);">

    @csrf

    <label>Category</label><br>
    <select name="category_id" required>
        @foreach(\App\Models\Category::all() as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select><br><br>

    <label>Product Name</label><br>
    <input type="text" name="name" required><br><br>

    <button type="submit">Add Product</button>
</form>

<hr>

{{-- ADD VARIANT --}}
<form method="POST"
      action="/api/inventory/variants"
      onsubmit="event.preventDefault(); submitVariant(this);">

    @csrf

    <label>Product</label><br>
    <select name="product_id" required>
        @foreach(\App\Models\Product::all() as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
        @endforeach
    </select><br><br>

    <label>Variant Name</label><br>
    <input type="text" name="variant_name" value="Standard"><br><br>

    <label>Cost Price</label><br>
    <input type="number" name="cost_price" step="0.01"><br><br>

    <label>Selling Price</label><br>
    <input type="number" name="selling_price" step="0.01" required><br><br>

    <label>Barcode</label><br>
    <input type="text" name="barcode" required><br><br>

    <button type="submit">Add Variant</button>
</form>

<hr>

{{-- PRODUCT LIST --}}
@foreach ($products as $product)
    <h3>{{ $product->name }}</h3>

    <ul>
        @foreach ($product->variants as $variant)
            <li>
                {{ $variant->variant_name }} —
                ₹{{ $variant->selling_price }} —
                {{ $variant->barcode }}
            </li>
        @endforeach
    </ul>
@endforeach

<script>
function submitProduct(form) {
    ajaxForm(form, () => {
        alert('Product added');
        form.reset();
        window.location.reload();
    }).catch(err => {
        alert(Object.values(err.errors)[0][0]);
    });
}

function submitVariant(form) {
    ajaxForm(form, () => {
        alert('Variant added');
        form.reset();
        window.location.reload();
    }).catch(err => {
        alert(Object.values(err.errors)[0][0]);
    });
}
</script>

@endsection
