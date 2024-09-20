<?php

namespace App\Helpers;

class URLHelper {

  /**
   * Construct valid previous url.
   *
   * @return string
   */
  public static function getFormPreviousUrl(): string {
    if (request()->has("previous_url")) {
      $url = request()->get("previous_url");
      session()->flash("previous_url", $url);
    }

    if (session()->exists("previous_url"))
      return session()->get("previous_url");

    return url()->previous();
  }
}
