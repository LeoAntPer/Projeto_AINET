@extends('template.layout')
@section('titulo', 'Catálogo')
@section('main')
    <form method="GET" action="{{ route('tshirt_images.index') }}">
        <div class="d-flex justify-content-between">
            <div class="flex-grow-1 pe-2">
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 mb-3 form-floating">
                        <input type="text" class="form-control" name="name" id="inputName" value="{{ old('name', $filterByName) }}">
                        <label for="inputName" class="form-label">Name</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="flex-grow-1 mb-3 form-floating m-1">
                        <input type="text" class="form-control" name="description" id="inputDescription" value="{{ old('name', $filterByDescription) }}">
                        <label for="inputDescription" class="form-label">Description</label>
                    </div>
                    <div class="flex-grow-1 mb-3 form-floating m-1">
                        <select class="form-select" name="category" id="inputCategory">
                            <option {{ old('category', $filterByCategory) === '' ? 'selected' : '' }} value="">Every category</option>
                            @foreach($categories as $category)
                                <option {{ old('category', $filterByCategory) == $category->id ? 'selected' : '' }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label for="inputCategory" class="form-label">Category</label>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-1 d-flex flex-column justify-content-between">
                <button type="submit" class="btn btn-primary mb-3 px-4 flex-grow-1" name="filtrar">Filtrar</button>
                <a href="#"
                   class="btn btn-secondary mb-3 py-3 px-4 flex-shrink-1">Limpar</a>
            </div>
        </div>
    </form>
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
            <a href="#"><img class="card-img-top img-fluid" src="{{ $image->fullTshirt_imageUrl }}" style="background-color: #2f2f2f; width: 200px; height: 200px; align-content: center" alt="Imagem"></a>
            <div class="d-flex flex-column align-items-center p-1">
                <h5 class="card-title d-inline-block text-truncate" style="max-width: 200px; object-fit: fill">{{$image->name}}</h5>
                <p>Category: {{ $image->category->name ?? 'none'  }}</p>
                <div class="d-flex flex-row">
                    <a href="#" class="btn btn-primary"><i class="fas fa-eye"></i></a>
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
