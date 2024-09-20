<?php

namespace App\Http\Requests\Contestant;

use App\Http\Requests\BaseRequest;

class UpdateTeamMemberRequest extends BaseRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            "name" => ["required", "string", "max:100"],
            "email" => ["required", "email"],
            "phone" => ["required", "string"],
            "is_leader" => ["nullable", "string"],
            "national_id" => ["required", "digits:16"],
            "student_id" => ["required", "numeric"],
            "national_id_file" => ["nullable", "mimes:jpg,png", "max:1000"],
            "student_id_file" => ["nullable", "mimes:jpg,png", "max:1000"]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            "mimes" => "The :attribute file type should be :values"
        ];
    }
}
