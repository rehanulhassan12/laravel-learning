<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use App\Models\ClassRoom;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRoomRequest extends FormRequest
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
    $id = $this->route('class')->id;

    return [
        'school_id' => ['required', 'exists:schools,id'],

        'name' => ['required', 'string', 'max:255'],

        'session_year' => [
            'required',
            'string',
            'max:9',
        ],

        'section' => [
            'nullable',
            'string',
            'max:50',

            // unique per school + name + session (ignore current)
            Rule::unique('classes')->where(fn ($query) =>
                $query->where('school_id', $this->input('school_id'))
                      ->where('name', $this->input('name'))
                      ->where('session_year', $this->input('session_year'))
            )->ignore($id),

            // required if another class exists with same name + school + session
            Rule::requiredIf(function () use ($id) {
                return ClassRoom::where('school_id', $this->input('school_id'))
                    ->where('name', $this->input('name'))
                    ->where('session_year', $this->input('session_year'))
                    ->where('id', '!=', $id)
                    ->exists();
            }),
        ],
    ];
}

}
