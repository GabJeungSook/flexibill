<?php

namespace App\Filament\Resources\DownpaymentResource\Pages;

use App\Filament\Resources\DownpaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDownpayment extends EditRecord
{
    protected static string $resource = DownpaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
          //  Actions\DeleteAction::make(),
        ];
    }
}
