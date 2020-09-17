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
            'departure_city' => 'required|string|max:190',
            'departure_city_to_airport' => 'required|string|max:190',
            'arrival_city' => 'required|string|max:190',
            'arrival_city_to_airport' => 'required|string|max:190',
            'price_first' => 'required|numeric',
            'price_second' => 'required|numeric',
        ];
    }
}
