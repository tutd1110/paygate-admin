<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ValidateJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class ChangeAvatar extends FormRequest
{
    use ValidateJsonResponse;

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
            'image' => 'required|image'
        ];
    }
}
