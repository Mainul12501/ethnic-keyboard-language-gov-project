<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpazilaRequest extends FormRequest
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
            'name'=>'required|string|regex:/^[a-zA-Z ]+$/u|unique:upazilas,name',
            'bn_name'=>'required|string|regex:/^[\p{Bengali} ]{0,100}$/u|unique:upazilas,bn_name',
            'district_id'=>'required',
        ];
    }
}
