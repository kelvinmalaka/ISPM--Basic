<?php

namespace App\Http\Requests\Contestant;

use App\Http\Requests\BaseRequest;
use App\Models\AnswerType;
use Illuminate\Support\Collection;

class StoreAnswerRequest extends BaseRequest {
    /**
     * Store answer types
     *
     * @var Collection
     */
    protected $types;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation() {
        $contest = $this->route("contest");

        $team = $contest->getContestantTeam();

        $team->load("category.answerTypes");
        $this->types = $team->category->answerTypes;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $rules = [
            "description" => ["nullable", "string"]
        ];

        $contest = $this->route("contest");
        $team = $contest->getContestantTeam();

        $types = $team->category->answerTypes;
        $types->each(function (AnswerType $type, int $index) use (&$rules) {
            $sizeMB = $type->max_size * 1000;

            $rules["answers." . $index . ".id"] = ['required', 'numeric'];
            $rules["answers." . $index . ".file"] = ['required', 'mimes:' . $type->file_type, 'max:' . $sizeMB];
        });

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
        $attributes = [];

        $this->types->each(function (AnswerType $type, int $index) use (&$attributes) {
            $attributes["answers." . $index . ".file"] = $type->name;
        });

        return $attributes;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() {
        return [
            "required" => ":attribute is required to be submitted",
            "mimes" => ":attribute file type should be :values"
        ];
    }
}
