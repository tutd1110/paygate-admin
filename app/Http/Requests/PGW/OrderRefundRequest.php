<?php

namespace App\Http\Requests\PGW;

use App\Http\Requests\ValidateJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class OrderRefundRequest extends FormRequest
{
    use ValidateJsonResponse;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->method() == 'PUT') {
            return [
                'id' => 'nullable|integer',
                'status' => 'in:request,refused,appoved,finish',
            ];
        } elseif ($this->method() == 'POST') {
            return [
                'order_id' => 'required|integer',
                'landing_page_id' => 'required|integer',
                'partner_code' => 'required|string|max:25',
                'refund_value' => 'required|integer',
                'description' => 'nullable|string',
                'status' => 'in:request,refused,appoved,finish',
                'array_order_detail_id' => 'array|required',
                'array_order_detail_id.*' => 'nullable|integer',
                'created_by' => 'nullable|integer',
                'updated_by' => 'nullable|integer',
            ];
        }
    }
}
