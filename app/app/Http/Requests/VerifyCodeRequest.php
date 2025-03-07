<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'code' => 'required|string|size:6',
        ];
    }
}
