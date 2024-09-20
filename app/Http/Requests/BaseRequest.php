<?php

namespace App\Http\Requests;

use App\Helpers\URLHelper;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest {
  /**
   * Configure the validator instance.
   *
   * @param  \Illuminate\Validation\Validator  $validator
   * @return void
   */
  public function withValidator($validator) {
    $validator->after(function () {
      URLHelper::getFormPreviousUrl();
    });
  }
}
