@extends('template.layout')
@section('titulo', 'Catálogo')
@section('main')
<div style="display: flex; flex-direction: row; justify-content: space-between; flex-wrap: wrap">
    <div class="card">
        <a href="#"><img class="card-img-top img-fluid" src="/img/addImage.png" style="width: 200px; height: 200px; align-content: center" alt="Adicionar Imagem"></a>
        <div class="d-flex flex-column align-items-center p-1">
            <h5 class="card-title d-inline-block text-truncate">&nbsp;</h5>
            <a href="#" class="btn btn-primary">Adicionar Imagem</a>
        </div>
    </div>
    @foreach ($tshirtImages as $image)
        <div class="card" style="margin-bottom: 5px; margin-top: 5px; max-width: 200px">
            <a href="{{ route('image.show', ['imageId' => $image->id]) }}">
                <img class="card-img-top img-fluid" src="{{ $image->fullTshirt_imageUrl }}" style="background-color: #2f2f2f; width: 200px; height: 200px; align-content: center" alt="Imagem">
            </a>
            <div class="d-flex flex-column align-items-center p-1">
                <h5 class="card-title d-inline-block text-truncate" style="max-width: 200px; object-fit: fill">{{$image->name}}</h5>
                <div class="d-flex flex-row">
                    <a href="{{ route('image.show', ['imageId' => $image->id]) }}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                    <a href="#" class="btn btn-dark"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="#">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="delete" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
