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
    $id = $this->route('class')->id; // match route param
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

        // unique per school + class name, ignore current record
        Rule::unique('classes')->where(fn ($query) =>
            $query->where('name', $this->input('name'))
                  ->where('school_id', $this->input('school_id'))
        )->ignore($id),

        // required if another class with same name exists in the same school (ignoring current)
        Rule::requiredIf(function () use ($id) {
            return ClassRoom::where('name', $this->input('name'))
                            ->where('school_id', $this->input('school_id'))
                            ->where('id', '!=', $id)
                            ->exists();
        }),
    ],
];





}

}
