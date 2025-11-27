<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'           => 'sometimes|in:income,expense',
            'category'       => 'sometimes|string|max:100',
            'description'    => 'nullable|string',
            'amount'         => 'sometimes|numeric|min:0',
            'date'           => 'sometimes|date',
            'payment_method' => 'nullable|string|max:50',
            'status'         => 'nullable|string|max:50',
        ];
    }
}
