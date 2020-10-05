<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StorePricing extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'departure' => 'required|string|max:255',
            'arrival' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'price_turbo' => 'nullable|numeric',
            'price_light' => 'nullable|numeric',
            'price_medium' => 'nullable|numeric',
            'price_heavy' => 'nullable|numeric',
        ];
    }
}
