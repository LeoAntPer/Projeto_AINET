@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
<div>
    <label for="inputStatus">Status</label>
    <select name="status" id="inputStatus" {{ $disabledStr }}>
        <option {{ $order->status == 'pending' ? 'selected' : ''}}>pending</option>
        <option {{ $order->status == 'paid' ? 'selected' : ''}}>paid</option>
        <option {{ $order->status == 'closed' ? 'selected' : ''}}>closed</option>
        <option {{ $order->status == 'canceled' ? 'selected' : ''}}>canceled</option>
    </select>
</div>
<div>
    <label for="inputCustomer">Customer</label>
    <input type="text" name="customer_id" id="inputCustomer" {{ $disabledStr }} value="{{$order->customer_id}}">
</div>
<div>
    <label for="inputDate">Date</label>
    <input type="text" name="date" id="inputDate" {{ $disabledStr }} value="{{$order->date}}">
</div>
<div>
    <label for="inputTotalPrice">Total price</label>
    <input type="text" name="total_price" id="inputTotalPrice" {{ $disabledStr }} value="{{$order->total_price}}">
</div>
<div>
    <label for="inputNotes">Notes</label>
    <input type="text" name="notes" id="inputNotes" {{ $disabledStr }} value="{{$order->notes}}">
</div>
<div>
    <label for="inputNif">NIF</label>
    <input type="text" name="address" id="inputAddress" {{ $disabledStr }} value="{{$order->address}}">
</div>
<div>
    <label for="inputAddress">Address</label>
    <input type="text" name="nif" id="inputNif" {{ $disabledStr }} value="{{$order->nif}}">
</div>
<div>
    <label for="inputPaymentType">Payment type</label>
    <select name="payment_type" id="inputPaymentType" {{ $disabledStr }}>
        <option {{ $order->payment_type == 'VISA' ? 'selected' : ''}}>VISA</option>
        <option {{ $order->payment_type == 'MC' ? 'selected' : ''}}>MC</option>
        <option {{ $order->payment_type == 'PAYPAL' ? 'selected' : ''}}>PAYPAL</option>
    </select>
</div>
<div>
    <label for="inputPaymentRef">Payment ref</label>
    <input type="text" name="payment_ref" id="inputPaymentRef" {{ $disabledStr }} value="{{$order->payment_ref}}">
</div>
<div>
    <label for="inputReceipt">Receipt URL</label>
    <input type="text" name="receipt_url" id="inputReceipt" {{ $disabledStr }} value="{{$order->receipt_url}}">
</div>

