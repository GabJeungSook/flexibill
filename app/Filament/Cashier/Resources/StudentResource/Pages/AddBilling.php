<?php

namespace App\Filament\Cashier\Resources\StudentResource\Pages;

use App\Models\Student;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Cashier\Resources\StudentResource;

class AddBilling extends Page
{
    use InteractsWithForms;
    protected static string $resource = StudentResource::class;
    public $record;
    public ?array $data = [];
    protected static string $view = 'filament.cashier.resources.student-resource.pages.add-billing';

    public function mount($record): void
    {
        $this->record = Student::find($record);
        $this->form->fill([
            'first_name' => $this->record->first_name,
            'last_name' => $this->record->last_name,
            'grade' => $this->record->grade->name,
            'section' => $this->record->section->name,
            'tuition' => $this->record->grade->fees->first()->tuition,
            'misc' => $this->record->grade->fees->first()->misc,
            'books' => $this->record->grade->fees->first()->books,
            'total' => ($this->record->grade->fees->first()->tuition + $this->record->grade->fees->first()->misc + $this->record->grade->fees->first()->books),
           'balance' => $this->record->billings->first() != null ? $this->record->billings->first()->balance : ($this->record->grade->fees->first()->tuition + $this->record->grade->fees->first()->misc + $this->record->grade->fees->first()->books),
        ]);
        static::authorizeResourceAccess();
    }

    public function form(Form $form): Form
    {
        return $form

            ->schema([
                Fieldset::make('Student Information')
                ->schema([
                    TextInput::make('first_name')->disabled(),
                    TextInput::make('last_name')->disabled(),
                    TextInput::make('grade')->label('Grade Level')->disabled(),
                    TextInput::make('section')->disabled(),
                ])->columns(2),
                Fieldset::make('Billing Information')
                ->schema([
                    TextInput::make('tuition')->label('Tuition Fee')
                    ->prefix('₱')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->disabled(),
                   TextInput::make('misc')->label('Misceallaneous Fee')
                    ->prefix('₱')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->disabled(),
                      TextInput::make('books')->label('Books')
                    ->prefix('₱')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->disabled(),
                    TextInput::make('total')->label('Total')
                    ->prefix('₱')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->disabled(),
                    TextInput::make('balance')
                    ->label('Remaining Balance')
                    ->prefix('₱')
                   ->mask(RawJs::make('$money($input)'))
                   ->stripCharacters(',')
                   ->disabled(),
                    TextInput::make('payment')
                    ->prefix('₱')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->autofocus(),
                ])->columns(3),
            ])
            ->statePath('data');
    }

    public function addBilling()
    {
        $total = (float) str_replace(',', '', $this->data['total']);
        $payment = (float) str_replace(',', '', $this->data['payment']);
        $this->validate();
        $this->record->billings()->create([
            'paid' => $payment,
            'balance' => ($total - $payment),
            'total' => $total,
        ]);
        Notification::make()
        ->title('Success')
        ->success()
        ->body('Billing has been added successfully.')
        ->send();
        $this->redirect(StudentResource::getUrl('index'));
    }
}
