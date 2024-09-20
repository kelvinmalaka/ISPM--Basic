<?php

namespace App\Http\Requests\Contest;

use App\Http\Requests\BaseRequest;

class UpdateCategoryRequest extends BaseRequest {
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
            "title" => ["required", "string", "max:100"],
            "description" => ["required", "string"],
            "max_team_member" => ["required", "numeric", "min:1"],
            "max_answer_uploads" => ["required", "numeric", "min:1"],
            "guide_file" => ["nullable", "mimes:pdf", "max:5000"],
            "case_file" => ["nullable", "mimes:pdf", "max:5000"]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            "title" => "Contest Category Title",
            "description" => "Contest Category Description",
            "max_team_member" => "Maximum Team Member",
            "max_answer_uploads" => "Maximum Answer Uploaded",
            "guide_file" => "Contest Category Guide File",
            "case_file" => "Contest Category Case File"
        ];
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
