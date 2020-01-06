<?php

namespace App\Http\Requests\Client;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonalInfromation extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'sometimes|nullable|string',
            'date_of_birth' => 'sometimes|nullable|date_format:m/d/Y',

            'address' => 'sometimes|nullable|string',
            'country' => 'sometimes|nullable|string',
            'city' => 'sometimes|nullable|string',
            'state' => 'sometimes|nullable|string',
            'postcode' => 'sometimes|nullable|string',

            'billing_address' => 'sometimes|nullable|string',
            'billing_country' => 'sometimes|nullable|string',
            'billing_city' => 'sometimes|nullable|string',
            'billing_state' => 'sometimes|nullable|string',
            'billing_postcode' => 'sometimes|nullable|string',
        ];
    }
}
