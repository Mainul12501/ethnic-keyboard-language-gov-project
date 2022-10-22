<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => 'required|string',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'avatar'      => 'required|image|dimensions:min_width=10,min_height=20',
            'phone'    => 'required|regex:/(01)[0-9]{9}/|min:11|max:11|unique:users',
            'role'    => 'required',
        ];
    }
}
