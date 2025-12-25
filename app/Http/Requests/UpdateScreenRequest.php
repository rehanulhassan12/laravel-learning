<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScreenRequest extends FormRequest
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
       $id = $this->route('screen')->id;
return [
    'name' => 'required|string|max:255|unique:screens,name,' . $id,
    'route_name' => 'required|string|max:255|unique:screens,route_name,' . $id,
    'icon' => 'nullable|string|max:100',
    'parent_id' => 'nullable|exists:screens,id',
];

    }
}
