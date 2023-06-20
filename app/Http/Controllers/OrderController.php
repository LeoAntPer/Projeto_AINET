<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::all();
        $filterByStatus = $request->status ?? '';
        $filterByPayment = $request->payment_type ?? '';
        $filterByNif = $request->nif ?? '';
        $orderQuery = Order::query();
        if ($filterByStatus !== '') {
            $orderQuery->where('status', $filterByStatus);
        }
        if ($filterByPayment !== '') {
            $orderQuery->where('payment_type', $filterByPayment);
        }
        if ($filterByNif !== '') {
            $orderQuery->where('nif', $filterByNif);
        }
        $orders = $orderQuery->paginate(10);
        return view('orders.index', compact(
            'orders',
            'filterByStatus',
            'filterByNif',
            'filterByPayment'
        ));
    }

    public function create(): View
    {
        return view('orders.create');
    }
    public function store(OrderRequest $request): RedirectResponse
    {
        $newOrder = Order::create($request->validated());
        $url = route('orders.show', ['order' => $newOrder]);
        $htmlMessage = "Order <a href='$url'>#{$newOrder->id}</a>
            <strong>\"{$newOrder->nome}\"</strong> foi criada com sucesso!";
        return redirect('/orders')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(Order $order): View
    {
        return view('orders.edit')->withOrder($order);
    }
    public function update(OrderRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->validated());
        $url = route('orders.show', ['order' => $order]);
        $htmlMessage = "Order <a href='$url'>#{$order->id}</a>
            <strong>\"{$order->user->name}\"</strong> foi alterada com sucesso!";
        return redirect()->route('orders.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(Order $order): RedirectResponse
    {
        try {
            $order->delete();
            $htmlMessage = "Order #{$order->id}
            <strong>\"{$order->nome}\"</strong>
            foi apagada com sucesso!";
            $alertType = 'success';
        } catch (\Exception $error) {
            $url = route('orders.show', ['order' => $order]);
            $htmlMessage = "Não foi possível apagar a order
            <a href='$url'>#{$order->id}</a>
            <strong>\"{$order->user->name}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return redirect()->route('orders.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function show(Order $order): View
    {
        return view('orders.show')->withOrder($order);
    }
}

