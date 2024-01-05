<?php

namespace App\Filament\Cashier\Resources\TransactionReportResource\Pages;

use App\Filament\Cashier\Resources\TransactionReportResource;
use Filament\Resources\Pages\Page;
use App\Models\Transaction;

class ReportTransaction extends Page
{
    protected static string $resource = TransactionReportResource::class;

    protected static string $view = 'filament.cashier.resources.transaction-report-resource.pages.report-transaction';
    protected static ?string $title = 'Sales Report';
    public $record;
    public function mount(): void
    {
        $this->record = Transaction::get();
        static::authorizeResourceAccess();
    }
}
