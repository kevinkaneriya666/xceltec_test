<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rules['fname'] = 'required|max:255';
        $rules['lname'] = 'required|max:255';
        $rules['dob'] = 'required';
        $rules['phone'] = 'required';
        $rules['image'] = 'required|mimes:jpeg,png,jpg,gif,svg|max:5000';
        $rules['email'] = 'required';
        $rules['password'] = 'required';
        
        if($this->get('id')){
            unset($rules['password']);
            unset($rules['image']);
        }

        return $rules;
    }
}
