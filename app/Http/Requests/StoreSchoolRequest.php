<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $groupId = $this->input('school_group_id');
        $id = $this->route("id");
        return [
             'name' => 'required|unique:schools,name,' . $id . ',id,school_group_id,' . $groupId,
            'address'=>'nullable|string|max:255',
            'school_group_id'=>'required|exists:school_groups,id',
        ];
    }
}
