<?php

namespace App\Http\Requests\Assessment;

use App\Http\Requests\BaseRequest;

class UpdateAssessmentRequest extends BaseRequest {
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
            "assessments.*.id" => ["required", "numeric"],
            "assessments.*.score" => ["required", "numeric", "min:0", "max:100"],
            "assessments.*.feedback" => ["required", "string"]
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
        return [];
    }
}
