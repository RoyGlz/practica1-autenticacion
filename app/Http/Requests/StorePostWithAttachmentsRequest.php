<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostWithAttachmentsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title'         => 'required|string|min:5|max:200',
            'content'       => 'required|string|min:50',
            'category_id'   => 'required|exists:categories,id',
            'attachments'   => 'array|max:5',
            'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ];
    }

    public function messages()
    {
        return [
            'attachments.max'     => 'No puedes subir más de 5 archivos',
            'attachments.*.max'   => 'Cada archivo no debe superar 5MB',
            'attachments.*.mimes' => 'Solo se aceptan JPG, PNG, PDF, DOC, DOCX',
        ];
    }
}