<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Price;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    const ITEM_NOT_IN_CART = -1;
    public function show(): View
    {
        $cart = session('cart', []);
        $cartTotal = array_sum(array_column($cart, 'sub_total'));
        return view('cart.show', compact('cart', 'cartTotal'));
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
                $cart[$cartIndex]->sub_total += $cart[$cartIndex]->unit_price;
                return back();
            }

            // Create a temporary order_item (not in DB)
            $newOrderItem = new OrderItem();
            $newOrderItem->tshirt_image_id = $tshirt_image_id;
            $newOrderItem->color_code = $color_code;
            $newOrderItem->size = $size;
            $newOrderItem->qty = 1;
            $prices = Price::query()->first();
            $orderPrice = $newOrderItem->tshirtImage->customer_id == null ? $prices->unit_price_catalog : $prices->unit_price_own;
            $newOrderItem->unit_price = $orderPrice;
            $newOrderItem->sub_total = $newOrderItem->qty * $newOrderItem->unit_price;
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
            $orderItem->sub_total -= $orderItem->unit_price;
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

    public function store(Request $request): RedirectResponse
    {
        try {
            $cart = session('cart', []);

            // Se o cart estiver vazio
            if (count($cart) < 1) {
                // Dialog
                return back();
            }
//            DB::transaction(function () use ($aluno, $cart) {
//                foreach ($cart as $disciplina) {
//                    $aluno->disciplinas()->attach($disciplina->id, ['repetente' => 0]);
//                }
//            });
        }
        catch (\Exception $error) {
            // Dialog
        }
        return back();
    }

    public function checkout(Request $request): View
    {
        // TODO: authorization
        $cart = session('cart', []);
        $cartTotal = array_sum(array_column($cart, 'sub_total'));
        $order = new Order();
        $customer = Customer::query()->where('id', '=', $request->user()->id)->first();
        $order->address = $customer->address;
        $order->payment_type = $customer->default_payment_type;
        $order->payment_ref = $customer->default_payment_ref;
        $order->nif = $customer->nif;
        return view('cart.checkout', compact('cart', 'cartTotal', 'order'));
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
