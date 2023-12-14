<?php

namespace App\Filament\Cashier\Resources\StudentResource\Pages;

use App\Models\Student;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Filament\Resources\Pages\Page;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Cashier\Resources\StudentResource;

class AddBilling extends Page
{
    use InteractsWithForms;
    protected static string $resource = StudentResource::class;
    public $record;
    public $total;
    public $balance;
    public ?array $data = [];
    protected static string $view = 'filament.cashier.resources.student-resource.pages.add-billing';

    public function mount($record): void
    {
        $this->record = Student::find($record);
        $this->total = ($this->record->grade->fees->first()->tuition + $this->record->grade->fees->first()->misc + $this->record->grade->fees->first()->books);
        $this->balance = $this->record->billings->first() != null ? $this->record->billings->first()->balance : ($this->record->grade->fees->first()->tuition + $this->record->grade->fees->first()->misc + $this->record->grade->fees->first()->books);
        $this->form->fill([
            'first_name' => $this->record->first_name,
            'last_name' => $this->record->last_name,
            'grade' => $this->record->grade->name,
            'section' => $this->record->section->name,
        //     'tuition' => $this->record->grade->fees->first()->tuition,
        //     'misc' => $this->record->grade->fees->first()->misc,
        //     'books' => $this->record->grade->fees->first()->books,
        //     'total' => ($this->record->grade->fees->first()->tuition + $this->record->grade->fees->first()->misc + $this->record->grade->fees->first()->books),
        //    'balance' => $this->record->billings->first() != null ? $this->record->billings->first()->balance : ($this->record->grade->fees->first()->tuition + $this->record->grade->fees->first()->misc + $this->record->grade->fees->first()->books),
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
                    Placeholder::make('tuition')
                    ->label('Tuition Fee: '),
                    Placeholder::make('tuition_fee')
                    ->content(new HtmlString('<h1 class="font-bold" style="text-align: right;">₱ '.number_format($this->record->grade->fees->first()->tuition, 2).'</h1>'))
                    ->label(' '),
                    Placeholder::make('misc')
                    ->label('Misceallaneous Fee: '),
                    Placeholder::make('misc_fee')
                    ->content(new HtmlString('<h1 class="font-bold" style="text-align: right;">₱ '.number_format($this->record->grade->fees->first()->misc, 2).'</h1>'))
                    ->label(' '),
                    Placeholder::make('books')
                    ->label('Books: '),
                    Placeholder::make('books_fee')
                    ->content(new HtmlString('<h1 class="font-bold" style="text-align: right;">₱ '.number_format($this->record->grade->fees->first()->books, 2).'</h1>'))
                    ->label(' '),
                    Placeholder::make('total')
                    ->content(new HtmlString('<div class="font-bold" style="text-align: right; margin-top: 20px;"></div>'))
                    ->label('Total: '),
                    Placeholder::make('total_fee')
                    ->content(new HtmlString('<h1 class="font-bold" style="text-align: right;">₱ '.number_format($this->total, 2).'</h1>'))
                    ->label(' '),
                    Placeholder::make('balance')
                    ->label('Balance: '),
                    Placeholder::make('balance_fee')
                    ->content(new HtmlString('<h1 class="font-bold" style="text-align: right;">₱ '.number_format($this->balance, 2).'</h1>'))
                    ->label(' '),
                    Placeholder::make('hidden_fee')
                    ->label(' '),
                    TextInput::make('payment')
                    ->prefix('₱')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->extraInputAttributes(['style' => 'text-align:right; font-weight: bold;',
                     'placeholder' => '0.00',
                     'text-size' => 'xl'])
                    ->required()
                    ->autofocus(),
                ])->columns(2),
            ])
            ->statePath('data');
    }

    public function redirectToStatement()
    {
        return redirect()->route('filament.cashier.resources.students.view_statement', $this->record);
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
