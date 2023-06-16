<table class="table">
    <thead class="table-dark">
    <tr>
        @if ($showOrder)
            <th>Order ID</th>
        @endif
        <th>Tshirt image ID</th>
        <th>Color Code</th>
        <th>Size</th>
        <th>Qty</th>
        <th>Unit price</th>
        <th>Sub total</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($orderItems as $order)
        <tr>
            @if ($showOrder)
                <td>{{ $order->orderRef->id }}</td>
            @endif
            <td>{{ $order->tshirt_image_id }}</td>
            <td>{{ $order->color_code }}</td>
            <td>{{ $order->size }}</td>
            <td>{{ $order->qty }}</td>
            <td>{{ $order->unit_price }}</td>
            <td>{{ $order->sub_total }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
