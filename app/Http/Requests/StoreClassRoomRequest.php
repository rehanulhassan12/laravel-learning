<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\ClassRoom;

class StoreClassRoomRequest extends FormRequest
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
    
return [
    'school_id' => ['required', 'exists:schools,id'],

    'name' => [
        'required',
        'string',
        'max:255',
    ],

    'section' => [
        'nullable',
        'string',
        'max:50',
        Rule::unique('classes')->where(fn ($query) =>
            $query->where('school_id', $this->input('school_id'))
                  ->where('name', $this->input('name'))
        ),
        Rule::requiredIf(function () {
            return ClassRoom::where('school_id', $this->input('school_id'))
                              ->where('name', $this->input('name'))
                              ->exists();
        }),
    ],
];
}


}
