<?php

namespace App\Http\Requests\Email;

use Illuminate\Foundation\Http\FormRequest;

class EmailTemplateRequest extends FormRequest
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
        } elseif ($this->method() == 'PUT') {
            return [
                'code'              => 'required|string',
                'name'              => 'required|string',
                'subject'           => 'required|string',
                'content'           => 'required|string',
                'attachment_files'  => 'nullable',
                'description'       => 'nullable|string',
                'status'            => 'in:active,inactive',

            ];
        } elseif ($this->method() == 'POST') {
            return [
                'code'              => 'required|string',
                'name'              => 'required|string',
                'subject'           => 'required|string',
                'content'           => 'required|string',
                'attachment_files'  => 'nullable',
                'description'       => 'nullable|string',
                'status'            => 'in:active,inactive',
            ];
        }
    }
    function messages()
    {
            return [
                'code.required'         => 'Code template không được trống',
                'name.required'         => 'Name template không được trống',
                'subject.required'      => 'subject template không được trống',
                'content.required'      => 'Nội dung template không được trống',
            ];
    }
}
