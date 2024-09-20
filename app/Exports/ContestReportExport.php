<?php

namespace App\Exports;

use App\Models\Contest;
use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ContestReportExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping, ShouldAutoSize {
    /**
     * Store contest
     * 
     * @var  Contest
     */
    protected $contest;

    /**
     * Class constructor
     * 
     * @return void
     */
    public function __construct(Contest $contest) {
        $this->contest = $contest;
    }

    /**
     * Set headings
     * 
     * @return array
     */
    public function headings(): array {
        return [
            'ID',
            'Name',
            'University',
            'Contest Category',
            'Overall Score',
            'Registration Status',
            'Registered Time'
        ];
    }

    /**
     * Set column formats
     * 
     * @return array
     */
    public function columnFormats(): array {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    /**
     * Get query data result as rows 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection() {
        return Team::with(["category", "registration"])
            ->whereRelation("contest", "contest_id", $this->contest->id)
            ->get();
    }

    /**
     * Maps rows data
     * 
     * @param   Team $team
     * @return  array
     */
    public function map($team): array {
        return [
            $team->id,
            $team->name,
            $team->university,
            $team->category->title,
            $team->overall_score,
            $team->registration->status->title,
            Date::dateTimeToExcel($team->created_at)
        ];
    }
}
