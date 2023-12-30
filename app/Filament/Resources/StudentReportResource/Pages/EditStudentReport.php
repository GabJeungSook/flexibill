<?php

namespace App\Filament\Resources\StudentReportResource\Pages;

use App\Filament\Resources\StudentReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentReport extends EditRecord
{
    protected static string $resource = StudentReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
