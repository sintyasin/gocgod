<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SignUpRequest extends Request
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
        $this->sanitize();

        return [
            'email' => 'required|email',
            //'address' => 'required',
            'city' => 'required|numeric',
            
            /*
            'dob' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'password' => 'required',
            'status' => 'required',
            'bank' => 'required'*/
        ];
    }

    public function sanitize()
    {
        $input = $this->all();

        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_STRING);
        $input['city'] = filter_var($input['city'], FILTER_SANITIZE_STRING);

        $this->replace($input);
    }

}