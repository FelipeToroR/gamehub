<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\User;

class UpdateUserRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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

        return [
            'name' => ['required', 'string', 'max:255'],
            'first_surname' => ['required', 'string', 'max:255'],
            'second_surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'integer', 'digits_between:1,2'],
            'course' => ['required', 'string', 'max:255'],
            'course_letter' => ['required', 'string', 'max:255'],
            'college' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$this->user],
            'password' => ['nullable', 'string', 'min:8'],
            'password_confirmation' => ['required_with:password']
        ];
    }
}
