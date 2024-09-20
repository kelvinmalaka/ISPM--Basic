<?php

namespace App\Faker;

use Faker\Provider\Base;
use Illuminate\Support\Collection;

class ContestCategoryProvider extends Base {
  /**
   * Fake contest category data.
   *
   * @var array
   */
  protected static $categories = [
    ["title" => "UI UX", "description" => "Description for UI UX contest category"],
    ["title" => "Web Application", "description" => "Description for Web Application contest category"],
    ["title" => "Mobile Application", "description" => "Description for Mobile Application contest category"],
    ["title" => "Game Development", "description" => "Description for Game Development contest category"],
    ["title" => "Business Innovation", "description" => "Description for Business Innovation contest category"],
    ["title" => "Short Movie", "description" => "Description for Short Movie contest category"],
    ["title" => "Robotic", "description" => "Description for Robotic contest category"],
    ["title" => "Blockchain", "description" => "Description for Blockchain contest category"]
  ];

  /**
   * Get a random contest category.
   *
   * @return array
   */
  public function contestCategory(): array {
    return static::randomElement(static::$categories);
  }

  /**
   * Get a random contest category except provided categories.
   *
   * @param  Collection  $except
   * @return array
   */
  public function contestCategoryExcepts(Collection $categories): array {
    return Collection::make(static::$categories)
      ->whereNotIn("title", $categories)
      ->random();
  }
}
