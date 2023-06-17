@extends('template.layout')
@section('titulo', "Alterar $customer->id")
@section('main')
    <form method="POST" action="{{ route('customers.update', ['customer' => $customer]) }}">
        @csrf
        @method('PUT')
        @include('customers.shared.fields')
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" name="ok" class="btn btn-primary">Save Customer</button>
            <a href="{{ route('customers.edit', ['customer' => $customer]) }}" class="btn btn-secondary ms-3">Cancelar</a>
        </div>
    </form>
@endsection
