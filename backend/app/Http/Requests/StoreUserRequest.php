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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required|min:4|max:25',
            'email'=>'required|unique:users|email',
            'password'=>'required|min:6|max:25',
            'lastname'=>'required|min:4|max:25',
            'numero_tlf'=>'integer|size:8',
            'Photo'=>'required'
        ];
    }
}
