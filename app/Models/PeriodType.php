<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodType extends Model {
    use HasFactory;

    public const REGISTRATION = "registration";
    public const REGISTRATION_VALIDATION = "registration_validation";
    public const CASE_DISTRIBUTION = "case_distribution";
    public const SUBMISSION = "submission";
    public const ANSWER_VALIDATION = "answer_validation";
    public const ASSESSMENT = "assessment";
    public const ANNOUNCEMENT = "announcement";

    /**
     * Map of available period types.
     *
     * @var array
     */
    private const PERIOD_TYPES_MAP = [
        self::REGISTRATION => [
            "title" => "Registration",
            "description" => "Contestant can register in a contest"
        ],
        self::REGISTRATION_VALIDATION => [
            "title" => "Registration Validation",
            "description" => "Committee can validate contestant registration"
        ],
        self::CASE_DISTRIBUTION => [
            "title" => "Case Distribution",
            "description" => "Contestant can download contest's case"
        ],
        self::SUBMISSION => [
            "title" => "Submission",
            "description" => "Contestant can submit or upload answers"
        ],
        self::ANSWER_VALIDATION => [
            "title" => "Answer Validation",
            "description" => "Committee can validate contestant answers"
        ],
        self::ASSESSMENT => [
            "title" => "Assessment",
            "description" => "Judge can assess contestant answers"
        ],
        self::ANNOUNCEMENT => [
            "title" => "Score Announcement",
            "description" => "Contestant can view their assessment results"
        ]
    ];

    /**
     * Get available period types.
     *
     * @return array
     */
    public static function getTypesMap(): array {
        return self::PERIOD_TYPES_MAP;
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;
}
