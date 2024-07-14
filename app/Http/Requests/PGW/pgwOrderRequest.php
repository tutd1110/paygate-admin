<?php

namespace App\Http\Requests\PGW;

use App\Http\Requests\ValidateJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class pgwOrderRequest extends FormRequest
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
                'phone' => 'required|string',
                'address' => 'nullable|string',
                'email' => 'nullable|string',
                'redirect_if_error' => 'nullable|string',
                'utm_campaign' => 'nullable|string',
                'utm_source' => 'nullable|string',
                'utm_medium' => 'nullable|string',
                'utm_content' => 'nullable|string',
                'utm_term' => 'nullable|string',
                'utm_creator' => 'nullable|string',
                'bill_code' => 'nullable|string|max:50',
                'code' => 'nullable|string|max:50',
                'partner_code' => 'required|string|max:50',
                'landing_page_id' => 'required|integer',
                'contact_lead_process_id' => 'nullable|integer',
                'order_client_id' => 'nullable|integer',
                'coupon_code' => 'nullable|string|max:25',
                'is_api' => 'in:yes,no',
                'merchant_code' => 'nullable|string|max:10',
                'banking_code' => 'nullable|string|max:10',
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
}
