<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerStatus extends Model {
    use HasFactory;

    public const APPROVED = "approved";
    public const REJECTED = "rejected";

    /**
     * Map of available answer statuses.
     *
     * @var array
     */
    private const STATUSES_MAP = [
        self::APPROVED => [
            "title" => "Approved",
            "description" => "Team's answer approved"
        ],
        self::REJECTED => [
            "title" => "Rejected",
            "description" => "Team's answer rejected"
        ]
    ];

    /**
     * Get available answer statuses.
     *
     * @return array
     */
    public static function getStatusesMap(): array {
        return self::STATUSES_MAP;
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = false;
}
