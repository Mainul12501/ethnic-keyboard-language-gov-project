<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataCollectorRequest extends FormRequest
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
            'avatar'    => 'required|image|dimensions:max_width=500,max_height=500',
            'join_date' => 'required|date',
            'phone'    => 'required|regex:/(01)[0-9]{9}/|min:11|max:11|unique:users',
            'nid'      => 'required|unique:users',
        ];
    }
}
