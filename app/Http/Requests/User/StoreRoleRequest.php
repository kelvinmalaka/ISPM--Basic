<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Models\Role;
use Illuminate\Validation\Rule;

class StoreRoleRequest extends BaseRequest {
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
        $roles = array_keys(Role::getRolesMap());

        return [
            "role" => ["required", "string", Rule::in($roles)]
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
            "role.in" => "Invalid role value"
        ];
    }
}
