<?php

namespace App\Http\Requests\PGW;

use App\Http\Requests\ValidateJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class InvoicesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'GET') {
            return [];
        }
        if ($this->method() == 'POST') {
            $countProduct = sizeof($this->input('item_product_id', []));
            return [
                'full_name' => 'required|string',
                'phone' => 'required|string|digits:10',
                'address' => 'nullable|string',
                'email' => 'nullable|string',
                'landing_page_id' => 'required|integer',
                'is_api' => 'in:1,0',
                'return_url_true' => 'nullable|string',
                'return_url_false' => 'nullable|string',
                'return_data' => 'nullable|string',

                'item_product_id' => 'array|required',
                'item_product_name' => 'array|required',
                'item_product_type' => 'array|nullable',
                'item_quantity' => 'array|nullable',
                'item_price' => 'array|required|size:' . $countProduct,
                'item_discount' => 'array|nullable',

                'item_product_id.*' => 'string|required',
                'item_product_type.*' => 'nullable|string|in:combo,package',
                'item_product_name.*' => 'required|string|nullable',
                'item_quantity.*' => 'nullable|integer',
                'item_price.*' => 'required|numeric',
                'item_discount.*' => 'nullable|numeric',
            ];
        }
    }
    public function messages(): array
    {
        return [
            'full_name.required' => 'Họ và tên không được để trống.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.digits' => 'Số điện thoại không đúng định dạng.',
        ];
    }
}
