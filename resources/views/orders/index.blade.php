@extends('template.layout')
@section('titulo', 'Order Items')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item">Orders</li>
    </ol>
@endsection

@section('main')
    <table class="table">
        <thead class="table-dark">
        <tr>
            <th>Satus</th>
            <th>Customer Id</th>
            <th>Date</th>
            <th>Total Price</th>
            <th>Address</th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
            <th class="button-icon-col"></th>
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
                <td class="button-icon-col">
                    <a   href="{{ route('orders.show', ['order' => $order]) }}" class="btn btn-secondary">
                        <i class="fas fa-eye"></i></a>
                </td>
                <td class="button-icon-col">
                    <a  href="{{ route('orders.edit', ['order' => $order]) }}" class="btn btn-dark">
                        <i class="fas fa-edit"></i></a>
                </td>
                <td>
                    <form method="POST" action="{{ route('orders.destroy', ['order' => $order]) }}" class="button-icon-col">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="fas fa-trash"></i></button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{ $orders->links() }}
    </div>
@endsection
