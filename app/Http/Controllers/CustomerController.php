<?php

namespace App\Http\Controllers;

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
            'nif'
        );
        $customers = $customerQuery->paginate(10);
        return view('customers.index', compact(
            'customers',
            'filterByNif',
            'filterByNome'
        ));
    }
}
