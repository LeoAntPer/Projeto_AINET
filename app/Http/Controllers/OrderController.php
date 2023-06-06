<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
class OrderController extends Controller
{
    public function index(): View
    {
        $allOrders = Order::all();
        return view('orders.index')->with('orders', $allOrders);
    }

    public function create(): View
    {
        return view('orders.create');
    }
    public function store(Request $request): RedirectResponse
    {
        Order::create($request->all());
        return redirect('/orders');
    }

    public function edit(Order $order): View
    {
        return view('orders.edit')->withOrder($order);
    }
    public function update(Request $request, Order $order): RedirectResponse
    {
        $order->update($request->all());
        return redirect()->route('orders.index');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index');
    }

    public function show(Order $order): View
    {
        return view('orders.show')->withOrder($order);
    }
}
