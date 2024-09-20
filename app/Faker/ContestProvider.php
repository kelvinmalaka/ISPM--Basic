<?php

namespace App\Faker;

use Faker\Provider\Base;

class ContestProvider extends Base {
  /**
   * Fake contest data.
   *
   * @var array
   */
  protected static $contests = [
    [
      "title" => "Business and System Innovation Competition 2023",
      "description" => "Description for contest Binus BASIC 2023"
    ],
    [
      "title" => "Project Extraordinary Competition 2024",
      "description" => "Description for contest PROXO 2024"
    ],
    [
      "title" => "IO Festival 2024",
      "description" => "Description for contest IO Festival 2024"
    ],
    [
      "title" => "Web Development Competition 2024",
      "description" => "Description for contest WDC 2024"
    ],
    [
      "title" => "National Invention Competition and Exhibition 2024",
      "description" => "Description for contest NICE 2024"
    ],
  ];

  /**
   * Get a random contest.
   *
   * @return array
   */
  public function contest(): array {
    return static::randomElement(static::$contests);
  }
}
