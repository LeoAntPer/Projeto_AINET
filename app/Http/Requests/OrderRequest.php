<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'customer_id',
                Rule::exists('users', 'id'),
            ],
            'status' => 'required|in:pending,paid,closed,canceled',
            'nif' => 'required|string|digits:9',
            'date' => 'required|date',
            'total_price' => 'required,numeric,regex:/^\d+(\.\d{1,2})?$/',
            'notes' => 'optional|string',
            'address' => 'required|string',
            'payment_type' => 'required|in:VISA,MC,PAYPAL',
        ];
    }
}

