<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Customer;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $filterByNif = $request->nif ?? '';
        $filterByNome = $request->nome ?? '';
        $customerQuery = Customer::leftJoin('users', 'customers.id', '=', 'users.id');
        if ($filterByNif !== '') {
            $customerQuery->where('nif', $filterByNif);
        }
        if ($filterByNome !== '') {
            $userIds = User::where('users.name', 'like', "%$filterByNome%")->pluck('users.id');
            $customerQuery->whereIntegerInRaw('customers.id', $userIds);
        }
        $customerQuery->select(
            'users.id',
            'users.name as nome_user',
            'nif',
            'users.blocked as blocked'
        );
        $customers = $customerQuery->paginate(10);
        return view('customers.index', compact(
            'customers',
            'filterByNif',
            'filterByNome'
        ));
    }

    public function create(): View
    {
        return view('customers.create');
    }
    public function store(CustomerRequest $request): RedirectResponse
    {
        $newCustomer = Customer::create($request->validated());
        $url = route('customers.show', ['customer' => $newCustomer]);
        $htmlMessage = "Customer <a href='$url'>#{$newCustomer->id}</a>
            <strong>\"{$newCustomer->id}\"</strong> foi criado com sucesso!";
        return redirect('/customers')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function edit(Customer $customer): View
    {
        return view('customers.edit')->withCustomer($customer);
    }
    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        $customer->update($request->validated());
        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "Customer <a href='$url'>#{$customer->id}</a>
            <strong>\"{$customer->id}\"</strong> foi alterado com sucesso!";
        return redirect()->route('customers.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        try {
            $customer->delete();
            $htmlMessage = "Customer #{$customer->id}
            <strong>\"{$customer->nome}\"</strong>
            foi apagado com sucesso!";
            $alertType = 'success';
        } catch (\Exception $error) {
            $url = route('customers.show', ['customer' => $customer]);
            $htmlMessage = "Não foi possível apagar o customer
            <a href='$url'>#{$customer->id}</a>
            <strong>\"{$customer->id}\"</strong> porque ocorreu um erro!";
            $alertType = 'danger';
        }
        return redirect()->route('customers.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', $alertType);
    }

    public function show(Customer $customer): View
    {
        return view('customer.show')->withCustomer($customer);
    }
}
