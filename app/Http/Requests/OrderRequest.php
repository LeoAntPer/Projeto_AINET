<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'status' => 'required|in:pending,paid,closed,canceled',
            'nif' => 'required|string|max:9',
            'address' => 'required|string',
            'payment_type' => 'required|in:VISA,MC,PAYPAL',
        ];
    }
}

