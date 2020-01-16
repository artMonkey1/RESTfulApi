<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

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
            'email' => ['email', 'unique:user,email,' . request()->user()->id],
            'password' => ['min:6', 'confirmed'],
            'admin' => ['in:' . User::ADMIN_USER . ',' . User::REGULAR_USER],
            'applicant' => ['in:' . User::APPLICANT_USER . ',' . User::READ_ONLY_USER]
        ];
    }
}
