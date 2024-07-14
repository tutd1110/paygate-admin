<?php

namespace App\Http\Requests\PGW;

use Illuminate\Foundation\Http\FormRequest;

class BankingRequest extends FormRequest
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
        if ($this->method() == 'GET') {
            return [];
        }
        if ($this->method() == 'POST' || $this->method() == 'PUT') {
            return [
                'name' => 'required|max:200',
                'code' => 'required|max:15',
                'thumb_path' => 'required',
            ];
        }
    }
    public function messages()
    {
        return [
            'name.required' => "Tên ngân hàng không được trống!",
            'name.max' => "Tên cổng thanh toán không quá 200 ký tự!",
            'code.required' => "Mã ngân hàng không được trống!",
            'code.max' => "Mã cổng thanh toán không quá 15 ký tự!",
            'thumb_path.required' => 'Ảnh không được trống',
        ];
    }
}
