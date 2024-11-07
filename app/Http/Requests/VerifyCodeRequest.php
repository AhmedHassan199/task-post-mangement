<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends BaseFormRequest
{

    public function authorize() :bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone_number' => 'required|string',
            'code' => 'required|digits:6',
        ];
    }
}
