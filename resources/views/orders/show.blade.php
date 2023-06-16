@extends('template.layout')

@section('titulo', "Order $order->id")

@section('main')
    <div>
        @include('orders.shared.fields', ['readonlyData' => true])
    </div>
    <div class="my-4 d-flex justify-content-end">
        <a href="{{ route('orders.edit', ['order' => $order]) }}" class="btn btn-secondary ms-3">Alterar Order</a>
    </div>
@endsection
