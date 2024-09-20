<?php

namespace App\Http\Requests\Contest;

use App\Http\Requests\BaseRequest;

class UpdateAssessmentComponentRequest extends BaseRequest {
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
            "description" => ["required", "string"],
            "weight" => ["required", "numeric", "min:1", "max:100"]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            "name" => "Assessment Component Name",
            "description" => "Assessment Component Description",
            "weight" => "Weight",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [];
    }
}
