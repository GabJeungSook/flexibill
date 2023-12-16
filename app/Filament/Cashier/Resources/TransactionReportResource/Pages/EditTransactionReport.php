<?php

namespace App\Filament\Cashier\Resources\TransactionReportResource\Pages;

use App\Filament\Cashier\Resources\TransactionReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransactionReport extends EditRecord
{
    protected static string $resource = TransactionReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
