@extends('layouts.app')

@section('content')
<h2>Stock</h2>

{{-- ADD OPENING STOCK --}}
<form method="POST"
      action="/api/inventory/stock/opening"
      onsubmit="event.preventDefault(); submitStock(this);">

    @csrf

    <label>Variant</label><br>
    <select name="product_variant_id" required>
        @foreach(\App\Models\ProductVariant::all() as $variant)
            <option value="{{ $variant->id }}">
                {{ $variant->product->name }} - {{ $variant->variant_name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Location</label><br>
    <select name="location_id" required>
        @foreach(\App\Models\Location::all() as $location)
            <option value="{{ $location->id }}">{{ $location->name }}</option>
        @endforeach
    </select><br><br>

    <label>Quantity</label><br>
    <input type="number" name="quantity" min="1" required><br><br>

    <button type="submit">Add Opening Stock</button>
</form>

<hr>

{{-- STOCK LIST --}}
<table>
    <tr>
        <th>Product</th>
        <th>Variant</th>
        <th>Location</th>
        <th>Qty</th>
    </tr>

    @foreach ($stocks as $stock)
        <tr>
            <td>{{ $stock->variant->product->name }}</td>
            <td>{{ $stock->variant->variant_name }}</td>
            <td>{{ $stock->location->name }}</td>
            <td>{{ $stock->quantity }}</td>
        </tr>
    @endforeach
</table>
<script>
function submitStock(form) {
    ajaxForm(form, () => {
        alert('Opening stock added');
        form.reset();
        window.location.reload();
    }).catch(err => {
        alert(Object.values(err.errors)[0][0]);
    });
}
</script>
    @endsection
