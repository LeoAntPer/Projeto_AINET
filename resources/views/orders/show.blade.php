@extends('template.layout')
@section('header-title', "Order $order->id")
@section('main')
    <div>
        @include('orders.shared.fields', ['readonlyData' => true])
    </div>
@endsection
