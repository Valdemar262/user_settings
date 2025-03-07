<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => 'required|string',
            'value' => 'required',
            'method' => 'required|in:email,sms,telegram',
        ];
    }
}
