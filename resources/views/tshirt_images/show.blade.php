@extends('template.layout')
@section('titulo', 'Imagem')
@section('main')
<!-- Form com varios input hidden para poder enviar os dados necessarios para criar um order_item sem ter na DB -->
<form action="{{ route('cart.add') }}" method="POST">
    @csrf
    <input type="hidden" name="imageID" value="{{ $imageId }}">
    <div class="card d-flex flex-row justify-content-between">
        <div>
            <img class="card-img-top img-fluid" src="{{ $image->fullTshirt_imageUrl }}" style="background-color: #2f2f2f; width: 300px; height: 300px; align-content: center" alt="Imagem">
            <div class="m-1">
                <h3 class="card-title" style="max-width: 300px; object-fit: fill">{{$image->name}}</h3>
                <p class="d-inline-block text-wrap" style="max-width: 300px">{{$image->description}}</p>
            </div>
        </div>
        <div class="card-img-top img-fluid d-flex justify-content-center" style="width: 400px; height: 400px; position: relative">
            <input type="hidden" name="color" value="{{ $basePreview->code }}">
            <img src="{{$basePreview->fullTshirtBaseUrl}}" alt="Tshirt Base Preview" style="width: 100%; height: 100%; z-index: 1; position: absolute">
            <img src="{{$image->fullTshirt_imageUrl}}" alt="Tshirt Image Preview" style="width: 50%; height: 50%; z-index: 2; position: absolute; top: 50%; transform: translateY(-50%)">
        </div>
        <div class="d-flex flex-column justify-content-end m-2">
            <button class="btn btn-primary" type="submit">Adicionar ao Carrinho</button>
        </div>
    </div>
<div class="card d-flex flex-row overflow-scroll card-img-top img-fluid">
    @foreach($bases as $base)
        <a href="{{ route('tshirt_images.show', ['tshirt_image' => $imageId, 'color' => $base->code]) }}">
            <img src="{{$base->fullTshirtBaseUrl}}" alt="Base de Tshirt" style="width: 150px; height: 150px">
        </a>
    @endforeach
</div>
    <!-- TODO: SIZES -->
    <input type="hidden" name="size" value="M">
</form>
@endsection
