@extends('template.layout')
@section('titulo', 'Edit item')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Shopping cart</li>
        <li class="breadcrumb-item active">Edit item</li>
    </ol>
@endsection

@section('main')
    <h1>{{ $orderItem->tshirt_image_id }}</h1>
@endsection
