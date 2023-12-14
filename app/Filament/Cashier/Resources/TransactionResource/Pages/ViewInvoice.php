<?php

namespace App\Filament\Cashier\Resources\TransactionResource\Pages;

use App\Mail\InvoiceMail;
use App\Models\Transaction;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use App\Filament\Cashier\Resources\TransactionResource;

class ViewInvoice extends Page
{
    public $record;
    protected static string $resource = TransactionResource::class;

    protected static string $view = 'filament.cashier.resources.transaction-resource.pages.view-invoice';

    public function sendEmailInvoice()
    {
        Mail::to($this->record->student->email)->send(new InvoiceMail($this->record));

        Notification::make()
        ->title('E-Invoice sent successfully')
        ->body('Email sent to '.$this->record->student->first_name.' '.$this->record->student->last_name)
        ->success()
        ->send();
    }

    public function mount($record): void
    {
        $this->record = Transaction::find($record);
        static::authorizeResourceAccess();
    }
}
