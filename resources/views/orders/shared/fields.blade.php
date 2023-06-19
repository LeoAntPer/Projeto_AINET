@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div class="mb-3 form-floating">
    <select class="form-select @error('status') is-invalid @enderror" name="status" id="inputStatus" {{ $disabledStr }}>
        <option {{ $order->status == "pending" ? 'selected' : ''}} >pending</option>
        <option {{ $order->status == "paid" ? 'selected' : ''}} >paid</option>
        <option {{ $order->status == "closed"? 'selected' : ''}} >closed</option>
        <option {{ $order->status == "canceled" ? 'selected' : ''}} >canceled</option>
    </select>
    <label for="inputStatus" class="form-label">Status</label>
    @error('status')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <input type="text" name="customer_id" id="inputCustomer" {{ $disabledStr }} value="{{$order->customer_id}}" class="form-control">
    <label for="inputCustomer" class="form-label">Customer</label>
</div>
<div class="mb-3 form-floating">
    <input type="text" name="date" id="inputDate" {{ $disabledStr }} value="{{$order->date}}" class="form-control">
    <label for="inputDate" class="form-label">Date</label>
</div>
<div class="mb-3 form-floating">
    <input type="text" name="total_price" id="inputTotalPrice" {{ $disabledStr }} value="{{$order->total_price}}" class="form-control">
    <label for="inputTotalPrice" class="form-label">Total price</label>
</div>
<div class="mb-3 form-floating">
    <input type="text" name="notes" id="inputNotes" {{ $disabledStr }} value="{{$order->notes}}" class="form-control">
    <label for="inputNotes" class="form-label">Notes</label>
</div>
<div class="mb-3 form-floating">
    <input type="text" name="address" id="inputAddress" {{ $disabledStr }} value="{{ old('address', $order->address) }}" class="form-control @error('address') is-invalid @enderror">
    <label for="inputAddress" class="form-label">Address</label>
    @error('address')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <input type="text" name="nif" id="inputNIF" {{ $disabledStr }} value="{{ old('nif', $order->nif) }}" class="form-control @error('nif') is-invalid @enderror">
    <label for="inputNIF" class="form-label">NIF</label>
    @error('nif')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="mb-3 form-floating">
    <select name="payment_type" id="inputPaymentType" {{ $disabledStr }} class="form-select @error('payment_type') is-invalid @enderror">
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
    <input type="text" name="payment_ref" id="inputPaymentRef" {{ $disabledStr }} value="{{$order->payment_ref}}" class="form-control">
    <label for="inputPaymentRef" class="form-label">Payment ref</label>
</div>
<div class="mb-3 form-floating">
    <input type="text" name="receipt_url" id="inputReceipt" {{ $disabledStr }} value="{{$order->receipt_url}}" class="form-control">
    <label for="inputReceipt" class="form-label">Receipt URL</label>
</div>
