<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistricRequest extends FormRequest
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
            'name'=>'required|string|regex:/^[a-zA-Z ]+$/u|unique:districts,name',
            'bn_name'=>'required|regex:/^[\p{Bengali} ]{0,100}$/u|string|unique:districts,bn_name',
        ];
    }
}
