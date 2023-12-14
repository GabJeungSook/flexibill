<?php

namespace App\Filament\Cashier\Resources\StudentResource\Pages;

use App\Models\Student;
use App\Mail\StatementMail;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;
use App\Filament\Cashier\Resources\StudentResource;

class ViewBillingStatement extends Page
{
    protected static string $resource = StudentResource::class;
    public $record;

    protected static string $view = 'filament.cashier.resources.student-resource.pages.view-billing-statement';

    public function redirectToPayment()
    {
        return redirect()->route('filament.cashier.resources.students.add', $this->record);
    }

    public function sendEmailStatement()
    {
        Mail::to($this->record->email)->send(new StatementMail($this->record));

        Notification::make()
        ->title('E-Statement sent successfully')
        ->body('Email sent to '.$this->record->first_name.' '.$this->record->last_name)
        ->success()
        ->send();

    }

    public function mount($record): void
    {
        $this->record = Student::find($record);
        static::authorizeResourceAccess();
    }
}
