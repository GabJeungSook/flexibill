<?php

namespace App\Filament\Resources\DownpaymentResource\Pages;

use App\Filament\Resources\DownpaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDownpayment extends CreateRecord
{
    protected static bool $canCreateAnother = false;
    protected static string $resource = DownpaymentResource::class;
}
