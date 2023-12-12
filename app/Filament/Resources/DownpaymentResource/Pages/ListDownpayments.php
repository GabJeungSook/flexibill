<?php

namespace App\Filament\Resources\DownpaymentResource\Pages;

use App\Filament\Resources\DownpaymentResource;
use App\Models\Downpayment;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDownpayments extends ListRecords
{
    protected static string $resource = DownpaymentResource::class;
    protected static ?string $title = 'Down Payment';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->visible(Downpayment::count() < 1),
        ];
    }
}
