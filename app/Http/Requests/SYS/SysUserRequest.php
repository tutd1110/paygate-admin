<?php

namespace App\Http\Requests\SYS;

use Illuminate\Foundation\Http\FormRequest;

class SysUserRequest extends FormRequest
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
                'fullname' => 'required|max:50',
                'email' => 'required|max:50',
                'status' => 'required',
                'owner' => 'required',
            ];
    }
    public function messages()
    {
        return [
            'fullname.required' => "Đây là trường bắt buộc!",
            'fullname.max' => "Bạn đã quá giới hạn 50 ký tự!",
            'email.required' => "Đây là trường bắt buộc!",
            'email.max' => "Bạn đã quá giới hạn 50 ký tự!",
            'status.required' => "Đây là trường bắt buộc!",
            'owner.required' => "Đây là trường bắt buộc!",
            'thumb_path.required' => "Đây là trường bắt buộc!",
        ];
    }
}
