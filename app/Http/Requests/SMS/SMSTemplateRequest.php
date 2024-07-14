<?php

namespace App\Http\Requests\SMS;

use Illuminate\Foundation\Http\FormRequest;

class SMSTemplateRequest extends FormRequest
{
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
                'template_name' => 'nullable|string',
                'code' => 'nullable|string',
                'event' => 'nullable|string',
                'status' => 'in:active,inactive',
                'bind_param' => 'string|nullable',
                'landing_page_id' => 'integer|nullable',
                'content' => 'required',
            ];
        } elseif ($this->method() == 'POST') {
            return [
                'template_name' => 'required|string',
                'code' => 'required|string',
                'event' => 'required|string',
                'status' => 'in:active,inactive',
                'content' => 'required',
                'bind_param' => 'string|nullable',
                'landing_page_id' => 'integer|nullable',
            ];
        }
    }
    function messages()
    {
        return [
            'template_name.required' => 'Template Name không được trống',
            'code.required' => 'Code không được trống',
            'event.required' => 'Event không được trống',
            'content.required' => 'Nội dung không được trống',
            'bind_param.required' => 'Bind Param không được trống',
            'landing_page_id.required' => 'Landing Page không được trống',

        ];
    }
}
