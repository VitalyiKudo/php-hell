<?php

namespace App\Http\Requests\Client;

use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAccount extends FormRequest
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
        $user = Auth::user();

        return [
            'email' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'email')->ignore($user),
            ],
            'password' => 'sometimes|nullable|string|min:8|confirmed',
        ];
    }
}
