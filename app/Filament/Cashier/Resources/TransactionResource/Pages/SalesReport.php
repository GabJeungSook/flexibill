<?php

namespace App\Filament\Cashier\Resources\TransactionResource\Pages;

use App\Filament\Cashier\Resources\TransactionResource;
use Filament\Resources\Pages\Page;

class SalesReport extends Page
{
    protected static string $resource = TransactionResource::class;

    protected static string $view = 'filament.cashier.resources.transaction-resource.pages.sales-report';

    public function mount(): void
    {
        static::authorizeResourceAccess();
    }
}
