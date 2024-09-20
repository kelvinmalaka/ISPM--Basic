<?php

namespace App\Http\Requests\Contest;

use App\Http\Requests\BaseRequest;

class UpdateContestRequest extends BaseRequest {
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
            "title" => ["required", "string", "max:200"],
            "description" => ["required", "string"],
            "administrator" => ["numeric", "nullable"],
            "guide_file" => ["nullable", "mimes:pdf", "max:5000"],
            "banner_img" => ["nullable", "mimes:jpg,png", "max:1000"]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        return [
            "title" => "Contest Title",
            "description" => "Contest Description",
            "administrator" => "Administrator",
            "guide_file" => "Contest Guide",
            "banner_img" => "Contest Banner Image"
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
