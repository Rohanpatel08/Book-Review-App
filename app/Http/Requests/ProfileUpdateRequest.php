<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'string',
            'email' => 'email|unique:users,email,' . Auth::user()->id . ',id',
            'profile' => 'image|max:2048'
        ];
    }
}
