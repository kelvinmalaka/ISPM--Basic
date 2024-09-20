<?php

namespace App\Http\Requests\Contest;

use App\Http\Requests\BaseRequest;
use App\Models\AnswerType;
use Illuminate\Validation\Rule;

class StoreAnswerTypeRequest extends BaseRequest {
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
            "file_type" => ["required", Rule::in(AnswerType::VAILD_FILE_TYPES)],
            "max_size" => ["required", "numeric"]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            "name" => "Answer Type Name",
            "description" => "Answer Type Description",
            "file_type" => "Answer Document File Type",
            "max_size" => "Maximum Answer Document Size",
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
