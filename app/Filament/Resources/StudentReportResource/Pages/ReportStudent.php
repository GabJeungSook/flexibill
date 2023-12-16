<?php

namespace App\Filament\Resources\StudentReportResource\Pages;

use App\Filament\Resources\StudentReportResource;
use Filament\Resources\Pages\Page;
use App\Models\Student;

class ReportStudent extends Page
{
    protected static string $resource = StudentReportResource::class;

    protected static string $view = 'filament.resources.student-report-resource.pages.report-student';
    protected static ?string $title = 'Students';
    public $record;

    public function mount(): void
    {
        $this->record = Student::all();
        static::authorizeResourceAccess();
    }
}
