@extends('template.layout')
@section('titulo', 'Imagem')
@section('main')
<div class="card d-flex flex-row">
    <div>
        <a href="#"><img class="card-img-top img-fluid" src="{{ $image->fullTshirt_imageUrl }}" style="background-color: #2f2f2f; width: 300px; height: 300px; align-content: center" alt="Imagem"></a>
        <h3 class="card-title" style="max-width: 300px; object-fit: fill">{{$image->name}}</h3>
        <p class="d-inline-block text-wrap" style="max-width: 300px">{{$image->description}}</p>
    </div>
</div>
@endsection
