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
            'time_turbo' => 'nullable|string|max:255',
            'price_turbo' => 'nullable|numeric',
            'time_light' => 'nullable|string|max:255',
            'price_light' => 'nullable|numeric',
            'time_medium' => 'nullable|string|max:255',
            'price_medium' => 'nullable|numeric',
            'time_heavy' => 'nullable|string|max:255',
            'price_heavy' => 'nullable|numeric',
        ];
    }
}
