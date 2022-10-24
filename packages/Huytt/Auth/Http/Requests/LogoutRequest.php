<?php

namespace Huytt\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use function auth;

class LogoutRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required'
        ];
    }
}
