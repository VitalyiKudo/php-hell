<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
        $user = $this->route('user');

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'sometimes|nullable|string',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|nullable|string',

            'billing_address' => 'sometimes|nullable|string',
            'billing_address_secondary' => 'sometimes|nullable|string',
            'billing_country' => 'sometimes|nullable|string',
            'billing_city' => 'sometimes|nullable|string',
            'billing_province' => 'sometimes|nullable|string',
            'billing_postcode' => 'sometimes|nullable|string',
        ];
    }
}
