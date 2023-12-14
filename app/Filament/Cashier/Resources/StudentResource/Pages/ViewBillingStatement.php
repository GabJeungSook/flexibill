<?php

namespace App\Filament\Cashier\Resources\StudentResource\Pages;

use App\Models\Student;
use Filament\Resources\Pages\Page;
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

    public function mount($record): void
    {
        $this->record = Student::find($record);
        static::authorizeResourceAccess();
    }
}
