<?php

namespace App\Http\Requests\Contestant;

use App\Http\Requests\BaseRequest;

class StoreTeamRequest extends BaseRequest {
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
            "name" => ["required", "string", "max:254"],
            "university" => ["required", "string", "max:100"],
            "category" => ["required", "numeric"]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            "category" => "Contest Category"
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
