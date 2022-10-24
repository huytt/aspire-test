<?php

namespace Huytt\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function auth;

class AuthRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ];
    }
}
