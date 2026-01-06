@extends('layouts.app')

@section('content')
<h2>Stock Movements</h2>

<table>
    <tr>
        <th>Date</th>
        <th>Product</th>
        <th>Variant</th>
        <th>Location</th>
        <th>Type</th>
        <th>Qty</th>
        <th>Remarks</th>
    </tr>

    @foreach ($movements as $move)
        <tr>
            <td>{{ $move->created_at }}</td>
            <td>{{ $move->variant->product->name }}</td>
            <td>{{ $move->variant->variant_name }}</td>
            <td>{{ $move->location->name }}</td>
            <td>{{ $move->type }}</td>
            <td>{{ $move->quantity }}</td>
            <td>{{ $move->remarks }}</td>
        </tr>
    @endforeach
</table>
@endsection
