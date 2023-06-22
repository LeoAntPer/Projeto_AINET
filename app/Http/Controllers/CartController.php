<?php

namespace App\Http\Controllers;

use App\Models\Color;
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
            $validated = $request->validate([
                'imageID' => 'required|exists:tshirt_images,id',
                'color' => 'required|exists:colors,code',
                'size' => 'required|in:XS,S,M,L,XL',
            ]);
            $tshirt_image_id = $validated['imageID'];
            $color_code = $validated['color'];
            $size = $validated['size'];
            $cart = session('cart', []);

            $htmlMessage = "New item added to <a href=".route('cart.show').">shopping cart</a>";

            // Se ja existe um order_item igual apenas queremos aumentar a quantidade
            $cartIndex = $this->isAlreadyInCart($tshirt_image_id, $color_code, $size);
            if($cartIndex != self::ITEM_NOT_IN_CART){
                $cart[$cartIndex]->qty++;
                $cart[$cartIndex]->sub_total += $cart[$cartIndex]->unit_price;
                return back()
                    ->with('alert-msg', $htmlMessage)
                    ->with('alert-type', 'success');
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
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function removeFromCart(Request $request, int $cartIndex): RedirectResponse
    {
        $cart = session('cart', []);
        $orderItem = $cart[$cartIndex];

        $htmlMessage = "Item removed from <a href=".route('cart.show').">shopping cart</a>";

        // verificar se e para remover completamente do carrinho ou apenas baixar quantidade
        $fullDelete = $request->input('fullDelete') ?? false;
        if($fullDelete and $orderItem->qty > 1){
            $orderItem->qty--;
            $orderItem->sub_total -= $orderItem->unit_price;
            return back()
                ->with('alert-msg', $htmlMessage)
                ->with('alert-type', 'info');
        }
        // remover item do carrinho
        unset($cart[$cartIndex]);
        // se o carrinho esta vazio, refresh das variaveis de sessao
        if(count($cart) === 0){
            self::destroy($request);
        }
        $request->session()->put('cart', $cart);
        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(Request $request, int $cartIndex): View
    {
        $cart = session('cart', []);
        $orderItem = $cart[$cartIndex];
        $colors = Color::all();
        return view('cart.edit', compact('orderItem', 'colors', 'cartIndex'));
    }

    public function update(Request $request, int $cartIndex): RedirectResponse
    {
        // Validation
        $validated = $request->validate([
            'color' => 'required|exists:colors,code',
            'quantity' => 'required|integer',
            'size' => 'required|in:XS,S,M,L,XL',
        ],
        [
            'quantity.integer' => 'Quantity needs to be a number',
        ]);
        $color = $validated['color'];
        $quantity = intval($validated['quantity']);
        $size = $validated['size'];

        // Update
        $htmlMessage = "Item successfully updated. View in <a href=".route('cart.show').">shopping cart</a>";
        $cart = session('cart', []);
        $orderItem = $cart[$cartIndex];

        // if selected color, size and image already exists in cart => update qty and price
        $sameOrderItemIndex = $this->isAlreadyInCart($orderItem->tshirt_image_id, $color, $size, ignoreIndex: $cartIndex);
        if ($sameOrderItemIndex != self::ITEM_NOT_IN_CART) {
            $sameOrderItem = $cart[$sameOrderItemIndex];
            // atualizar valores
            $orderItem->qty = $quantity;
            $orderItem->qty += intval($sameOrderItem->qty);
            $orderItem->sub_total = $orderItem->qty * $orderItem->unit_price;
            // remove duplicated item
            unset($cart[$sameOrderItemIndex]);
            $request->session()->put('cart', $cart);
        }
        else{
            $orderItem->qty = $quantity;
            $orderItem->sub_total = $orderItem->qty * $orderItem->unit_price;
        }
        // normal update
        $orderItem->color_code = $color;
        $orderItem->size = $size;

        return back()
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
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
        $cart = session('cart', []);
        $cartTotal = array_sum(array_column($cart, 'sub_total'));
        $order = new Order();
        // TODO: authorization
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

    private function isAlreadyInCart($tshirt_image_id, $color_code, $size, $ignoreIndex = null): int
    {
        $cart = session('cart', []);
        foreach ($cart as $id => $orderItem){
            // pode ser preciso dar skip a si proprio
            if ($ignoreIndex != null and $id == $ignoreIndex) {
                continue;
            }

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
