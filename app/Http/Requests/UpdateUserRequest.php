<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email'     => ['required', Rule::unique('users')->ignore($this->user)],
            'phone'    => ['required','regex:/(01)[0-9]{9}/', 'min:11','max:11',Rule::unique('users', 'phone')->ignore($this->user)],
        ];
    }
}
