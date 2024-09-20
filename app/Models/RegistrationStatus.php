<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationStatus extends Model {
    use HasFactory;

    public const CREATED = "created";
    public const SUBMITTED = "submitted";
    public const REVISED = "revised";
    public const APPROVED = "approved";
    public const REJECTED = "rejected";

    /**
     * Map of available registration statuses.
     *
     * @var array
     */
    private const STATUSES_MAP = [
        self::CREATED => [
            "title" => "Created",
            "description" => "Contestant created a team to participate in a contest"
        ],
        self::SUBMITTED => [
            "title" => "Submitted",
            "description" => "Contestant submitted team registration",
        ],
        self::REVISED => [
            "title" => "Revised",
            "description" => "Contestant revised team registration data"
        ],
        self::APPROVED => [
            "title" => "Approved",
            "description" => "Team registration approved"
        ],
        self::REJECTED => [
            "title" => "Rejected",
            "description" => "Team registration rejected"
        ]
    ];

    /**
     * Get available registration statuses.
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

    /**
     * Get the status of the registration.
     * 
     * @param  string  $usid
     * @return RegistrationStatus
     */
    static public function findByUSID(string $usid): RegistrationStatus {
        return self::query()
            ->where("usid", "=", $usid)
            ->first();
    }
}
