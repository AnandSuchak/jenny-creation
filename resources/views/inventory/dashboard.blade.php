@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Inventory Dashboard</h1>

{{-- SUMMARY --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Categories</p>
        <p class="text-2xl font-semibold">{{ $stats['categories'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Products</p>
        <p class="text-2xl font-semibold">{{ $stats['products'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Variants</p>
        <p class="text-2xl font-semibold">{{ $stats['variants'] }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Total Stock</p>
        <p class="text-2xl font-semibold">{{ $stats['total_stock'] }}</p>
    </div>
</div>

{{-- STOCK BY LOCATION --}}
<div class="bg-white p-6 rounded shadow mb-8">
    <h2 class="font-semibold mb-4">Stock by Location</h2>

    <table class="w-full text-left">
        <tr class="border-b">
            <th class="pb-2">Location</th>
            <th class="pb-2">Total Qty</th>
        </tr>
        @foreach ($stockByLocation as $row)
            <tr class="border-t">
                <td class="py-2">{{ $row->location->name }}</td>
                <td class="py-2">{{ $row->total }}</td>
            </tr>
        @endforeach
    </table>
</div>

{{-- LOW STOCK --}}
<div class="bg-white p-6 rounded shadow mb-8">
    <h2 class="font-semibold mb-4 text-red-600">Low Stock Alerts</h2>

    @if($lowStock->isEmpty())
        <p class="text-gray-500">No low stock items 🎉</p>
    @else
        <table class="w-full text-left">
            <tr class="border-b">
                <th>Product</th>
                <th>Variant</th>
                <th>Location</th>
                <th>Qty</th>
            </tr>
            @foreach ($lowStock as $stock)
                <tr class="border-t">
                    <td>{{ $stock->variant->product->name }}</td>
                    <td>{{ $stock->variant->variant_name }}</td>
                    <td>{{ $stock->location->name }}</td>
                    <td class="text-red-600 font-semibold">{{ $stock->quantity }}</td>
                </tr>
            @endforeach
        </table>
    @endif
</div>

{{-- RECENT MOVEMENTS --}}
<div class="bg-white p-6 rounded shadow">
    <h2 class="font-semibold mb-4">Recent Stock Movements</h2>

    <table class="w-full text-left">
        <tr class="border-b">
            <th>Date</th>
            <th>Product</th>
            <th>Location</th>
            <th>Type</th>
            <th>Qty</th>
        </tr>
        @foreach ($recentMovements as $move)
            <tr class="border-t">
                <td>{{ $move->created_at->format('d M Y H:i') }}</td>
                <td>{{ $move->variant->product->name }}</td>
                <td>{{ $move->location->name }}</td>
                <td>{{ $move->type }}</td>
                <td>{{ $move->quantity }}</td>
            </tr>
        @endforeach
    </table>
</div>
@endsection
