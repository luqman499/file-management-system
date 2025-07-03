<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DispatchUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'flag_id' => 'required|exists:flags,id',
            'folder_id' => 'required|exists:folders,id',
            'office_id' => 'required|exists:offices,id',
            'title' => 'required|string|max:255',
            'dispatch_number' => 'required|string|max:255',
            'file_number' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'required',
            'send_to' => 'required|string|max:255',
            'received_from' => 'required|string|max:255',
            'remark' => 'nullable|string',
            'status' => 'required|integer|in:0,1,2,3,4',
            'attachments.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'selected_users' => 'nullable|array',
            'selected_users.*' => 'exists:users,id',
        ];
    }
}
