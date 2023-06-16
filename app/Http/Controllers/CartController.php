<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function show(): View
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request): RedirectResponse
    {
        try {
            // Create a temporary order_item (not in DB)
            $newOrderItem = new OrderItem();
            $newOrderItem->tshirt_image_id = $request->input('imageID');
            $newOrderItem->color_code = $request->input('color');
            $newOrderItem->size = $request->input('size');
            $cartId = session('cart_id', 0);
            $cart = session('cart', []);
            $cart[$cartId] = $newOrderItem;
            $cartId++;
            $request->session()->put('cart', $cart);
            $request->session()->put('cart_id', $cartId);
        } catch (\Exception $error) {
            // Dialog
        }
        return back();
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        $request->session()->forget('cart_id');
        return back();
    }
}
