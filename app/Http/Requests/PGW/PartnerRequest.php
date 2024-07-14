<?php

namespace App\Http\Requests\PGW;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
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
            return [
                'banking_code.*' => 'required',
                'owner' => 'required|array',
                'owner.*' => 'required|string',
                'branch.*' => 'required',
                'payment_merchant' => 'required',
                'bank_number.*' => 'required',
                'bank_business.*' => 'required',
                'code_res_bank.*' => 'required',
            ];
    }
    public function messages()
    {
        return [
            'banking_code.*.required' => 'Mã ngân hàng không được trống',
            'branch.*.required' => 'Chi nhánh ngân hàng không được trống',
            'bank_number.*.required' => 'Chưa nhập số tài khoản',
            'bank_business.*.required' => 'Thông tin kết nối đến ngân hàng không được trống',
            'code_res_bank.*.required' => 'Mã Code không được trống',
            'owner.*.required' => 'Tên chủ tài khoản không được trống',
        ];
    }
}
