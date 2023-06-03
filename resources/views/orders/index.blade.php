@extends('template.layout')
@section('header-title', 'Order Items')
@section('main')
<table>
    <thead>
    <tr>
        <th>Satus</th>
        <th>Customer Id</th>
        <th>Date</th>
        <th>Total Price</th>
        <th>Address</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($orders as $order)
        <tr>
            <td>{{ $order->status }}</td>
            <td>{{ $order->customer_id }}</td>
            <td>{{ $order->date }}</td>
            <td>{{ $order->total_price }}</td>
            <td>{{ $order->address }}</td>
            <td>
                <a href="{{ route('orders.edit', ['order' => $order]) }}">Alterar</a>
            </td>
            <td>
                <form method="POST" action="{{ route('orders.destroy', ['order' => $order]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" name="delete">Apagar</button>
                </form>
            </td>
            <td>
                <a href="{{ route('orders.show', ['order' => $order]) }}">Consultar</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
