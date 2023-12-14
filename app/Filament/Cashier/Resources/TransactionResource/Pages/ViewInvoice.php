<?php

namespace App\Filament\Cashier\Resources\TransactionResource\Pages;

use App\Filament\Cashier\Resources\TransactionResource;
use App\Models\Transaction;
use Filament\Resources\Pages\Page;

class ViewInvoice extends Page
{
    public $record;
    protected static string $resource = TransactionResource::class;

    protected static string $view = 'filament.cashier.resources.transaction-resource.pages.view-invoice';

    public function mount($record): void
    {
        $this->record = Transaction::find($record);
        static::authorizeResourceAccess();
    }
}
