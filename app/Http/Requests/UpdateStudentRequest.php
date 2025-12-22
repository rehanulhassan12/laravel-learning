<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'roll_no'     => 'nullable|string|max:50',
            'gender'      => 'required|in:male,female',
            'dob'         => 'date',
            'user_id'     => 'exists:users,id',

            'guardian_id' => 'required|exists:guardians,id',
            'class_id'    => 'required|exists:classes,id',
        ];
    }
}
