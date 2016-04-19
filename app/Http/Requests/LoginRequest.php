<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function sanitize()
    {
        $input = $this->all();

        $input['email'] = filter_var($input['email'], FILTER_SANITIZE_STRING);
        $input['password'] = filter_var($input['password'], FILTER_SANITIZE_STRING);

        $this->replace($input);
    }
}
