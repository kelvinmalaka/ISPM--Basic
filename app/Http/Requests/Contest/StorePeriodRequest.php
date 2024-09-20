<?php

namespace App\Http\Requests\Contest;

use App\Http\Requests\BaseRequest;

class StorePeriodRequest extends BaseRequest {
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
            "periods.*.id" => ["required", "numeric"],
            "periods.*.opened_at" => ["nullable", "date"],
            "periods.*.closed_at" => ["nullable", "date"]
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
