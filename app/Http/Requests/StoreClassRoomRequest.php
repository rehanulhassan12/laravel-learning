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

        'name' => ['required', 'string', 'max:255'],

        'session_year' => [
            'required',
            'string',
            'max:9', // e.g. 2023-2024
        ],

        'section' => [
            'nullable',
            'string',
            'max:50',

            // unique per school + name + session
            Rule::unique('classes')->where(fn ($query) =>
                $query->where('school_id', $this->input('school_id'))
                      ->where('name', $this->input('name'))
                      ->where('session_year', $this->input('session_year'))
            ),

            // section required if same class exists in same school + session
            Rule::requiredIf(function () {
                return ClassRoom::where('school_id', $this->input('school_id'))
                    ->where('name', $this->input('name'))
                    ->where('session_year', $this->input('session_year'))
                    ->exists();
            }),
        ],
    ];
}


}
