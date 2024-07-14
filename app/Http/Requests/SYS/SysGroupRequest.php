<?php

namespace App\Http\Requests\SYS;

use Illuminate\Foundation\Http\FormRequest;

class SysGroupRequest extends FormRequest
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
                'group_name' => 'required|max:50',
                'partner_code' => 'required',
                'status' => 'required',
                'description' => 'max:200',
            ];
        }
    }
    public function messages()
    {
            return [
                'group_name.required' => "Đây là trường bắt buộc!",
                'group_name.max' => "Bạn đã quá giới hạn 50 ký tự!",
                'partner_code.required' => "Đây là trường bắt buộc!",
                'status.required' => "Đây là trường bắt buộc!",
                'description.max' => "Bạn đã quá giới hạn 200 ký tự!",
            ];
        }
}
