@extends('template.layout')
@section('header-title', "Alterar $order->id")
@section('main')
    <form method="POST" action="{{ route('orders.update', ['order' => $order]) }}">
        @csrf
        @method('PUT')
        @include('orders.shared.fields')
        <div>
            <button type="submit" name="ok">Save new order</button>
        </div>
    </form>
@endsection
