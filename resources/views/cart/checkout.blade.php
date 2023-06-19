@extends('template.layout')
@section('titulo', 'Shopping cart')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Shopping cart</li>
        <li class="breadcrumb-item active">Checkout</li>
    </ol>
@endsection

@section('main')
{{--    @include('orders.shared.fields')--}}
    <div class="mb-3 form-floating">
        <input type="text" name="address" id="inputAddress" value="{{ old('address', $order->address) }}" class="form-control @error('address') is-invalid @enderror">
        <label for="inputAddress" class="form-label">Address</label>
        @error('address')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating">
        <input type="text" name="nif" id="inputNIF" value="{{ old('nif', $order->nif) }}" class="form-control @error('nif') is-invalid @enderror">
        <label for="inputNIF" class="form-label">NIF</label>
        @error('nif')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating">
        <select name="payment_type" id="inputPaymentType" class="form-select @error('payment_type') is-invalid @enderror">
            <option {{ $order->payment_type == 'VISA' ? 'selected' : ''}}>VISA</option>
            <option {{ $order->payment_type == 'MC' ? 'selected' : ''}}>MC</option>
            <option {{ $order->payment_type == 'PAYPAL' ? 'selected' : ''}}>PAYPAL</option>
        </select>
        <label for="inputPaymentType" class="form-label">Payment type</label>
        @error('payment_type')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-floating">
        <input type="text" name="payment_ref" id="inputPaymentRef" value="{{$order->payment_ref}}" class="form-control">
        <label for="inputPaymentRef" class="form-label">Payment ref</label>
    </div>
    <div class="mb-3 form-floating">
        <textarea name="notes" id="inputNotes" class="form-control">{{ $order->notes }}</textarea>
        <label for="inputNotes" class="form-label">Notes</label>
    </div>
@endsection
