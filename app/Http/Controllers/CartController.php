<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    const ITEM_NOT_IN_CART = -1;
    public function show(): View
    {
        $cart = session('cart', []);
        return view('cart.show', compact('cart'));
    }

    public function addToCart(Request $request): RedirectResponse
    {
        try {
            $tshirt_image_id = $request->input('imageID');
            $color_code = $request->input('color');
            $size = $request->input('size');
            $cart = session('cart', []);

            // Se ja existe um order_item igual apenas queremos aumentar a quantidade
            $cartIndex = $this->isAlreadyInCart($tshirt_image_id, $color_code, $size);
            if($cartIndex != self::ITEM_NOT_IN_CART){
                $cart[$cartIndex]->qty++;
                return back();
            }

            // Create a temporary order_item (not in DB)
            $newOrderItem = new OrderItem();
            $newOrderItem->tshirt_image_id = $tshirt_image_id;
            $newOrderItem->color_code = $color_code;
            $newOrderItem->size = $size;
            $newOrderItem->qty = 1;
            $cartId = session('cart_id', 0);


            // Add order_item to cart
            $cart[$cartId] = $newOrderItem;
            $cartId++;
            $request->session()->put('cart', $cart);
            $request->session()->put('cart_id', $cartId);
        } catch (\Exception $error) {
            // Dialog
        }
        return back();
    }

    public function removeFromCart(Request $request, int $cartIndex): RedirectResponse
    {
        $cart = session('cart', []);
        $orderItem = $cart[$cartIndex];

        // verificar se e para remover completamente do carrinho ou apenas baixar quantidade
        $fullDelete = $request->input('fullDelete') ?? false;
        if($fullDelete and $orderItem->qty > 1){
            $orderItem->qty--;
            return back();
        }
        // remover item do carrinho
        unset($cart[$cartIndex]);
        // se o carrinho esta vazio, refresh
        if(count($cart) === 0){
            self::destroy($request);
        }
        $request->session()->put('cart', $cart);
        return back();
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('cart');
        $request->session()->forget('cart_id');
        return back();
    }

    private function isAlreadyInCart($tshirt_image_id, $color_code, $size): int
    {
        $cart = session('cart', []);
        foreach ($cart as $id => $orderItem){
            if (
                $orderItem->tshirt_image_id == $tshirt_image_id and
                $orderItem->color_code == $color_code and
                $orderItem->size == $size
            )
            {
                return $id;
            }
        }
        return -1;
    }
}
