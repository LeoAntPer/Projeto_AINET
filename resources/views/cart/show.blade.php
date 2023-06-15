@extends('template.layout')
@section('titulo', 'Shopping cart')
@section('main')
    @foreach($cart as $orderItem)
        <img class="card-img-top img-fluid" src="{{ $orderItem->tshirtImage->fullTshirtImageUrl }}" style="background-color: #2f2f2f; width: 200px; height: 200px; align-content: center" alt="Imagem">
        <p>Size: {{ $orderItem->size }}</p>
        <p>Quantity: {{ $orderItem->qty }}</p>
        <p>Price: {{ $orderItem->unit_price }}</p>
        <p>Subtotal: {{ $orderItem->sub_total }}</p>
        <p>Color code: {{ $orderItem->color_code }}</p>
    @endforeach
    <form action="{{ route('cart.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Clear</button>
    </form>
<?php dump($cart) ?>
@endsection
