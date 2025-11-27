<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // sudah dijaga pakai auth:sanctum di route
    }

    public function rules(): array
    {
        return [
            'type'           => 'required|in:income,expense',
            'category'       => 'required|string|max:100',
            'description'    => 'nullable|string',
            'amount'         => 'required|numeric|min:0',
            'date'           => 'required|date',
            'payment_method' => 'nullable|string|max:50',
            'status'         => 'nullable|string|max:50',
        ];
    }
}
