<?php

namespace App\Http\Requests\PGW;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
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
                'description' => 'max:200',
                'thumb_path' => 'required',
                'sort' => 'required',
            ];
        }
    }
    public function messages()
    {
        return [
            'name.required' => "Tên cổng thanh toán không được trống!",
            'name.max' => "Tên cổng thanh toán không quá 200 ký tự!",
            'code.required' => "Mã cổng thanh toán không được trống!",
            'code.max' => "Mã cổng thanh toán không quá 15 ký tự!",
            'description.max' => "Mô tả không quá 200 ký tự!",
            'thumb_path.required' => 'Ảnh không được trống',
            'sort.required' => 'Vị trí không được trống',
        ];
    }
}
