<?php

namespace App\Http\Requests\Client;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreCard extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('client')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'number' => 'required|digits_between:15,16',
            'expiration_month' => 'required|numeric|min:1|max:12',
            'expiration_year' => 'required|numeric|min:19|max:99',
            'cvv' => 'required|digits_between:3,4',
        ];
    }
}
