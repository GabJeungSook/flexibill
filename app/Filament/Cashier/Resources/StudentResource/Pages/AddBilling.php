<?php

namespace App\Filament\Cashier\Resources\StudentResource\Pages;

use App\Models\Student;
use Filament\Forms\Form;
use App\Mail\InvoiceMail;
use App\Models\Downpayment;
use Filament\Support\RawJs;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Filament\Cashier\Resources\StudentResource;
use App\Filament\Cashier\Resources\TransactionResource;

class AddBilling extends Page
{
    use InteractsWithForms;
    protected static string $resource = StudentResource::class;
    public $record;
    public $total;
    public $balance;
    public $down_payment;
    public ?array $data = [];
    protected static string $view = 'filament.cashier.resources.student-resource.pages.add-billing';

    public function mount($record): void
    {
        $this->record = Student::find($record);
        $this->total = ($this->record->grade->fees->first()->tuition + $this->record->grade->fees->first()->misc + $this->record->grade->fees->first()->books);
        $this->balance = $this->record->transactions()->latest()->first() != null ? $this->record->transactions()->latest()->first()->balance : $this->total;
        $this->down_payment = Downpayment::first()->down_payment;
        $this->form->fill([
            'first_name' => $this->record->first_name,
            'last_name' => $this->record->last_name,
            'grade' => $this->record->grade->name,
            'section' => $this->record->section->name,
            'address' => $this->record->address,
            'email' => $this->record->email,
            'payment_type' => $this->record->transactions()->exists() ? 'cash' : 'down payment',
            'payment' => $this->record->transactions()->exists() ? null : $this->down_payment,
        ]);
        static::authorizeResourceAccess();
    }

    public function form(Form $form): Form
    {
        return $form

            ->schema([
                Section::make('Student Information')
                ->schema([
                        TextInput::make('first_name')->disabled(),
                        TextInput::make('last_name')->disabled(),
                        TextInput::make('grade')->label('Grade Level')->disabled(),
                        TextInput::make('section')->disabled(),
                        TextInput::make('address')->disabled(),
                        TextInput::make('email')->disabled(),
                ])->columns(2)
                ->collapsible(),
                Section::make('Billing Information')
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
                    Select::make('payment_type')
                    ->label('Payment Type')
                    ->required()
                    ->options([
                        'cash' => 'Cash',
                        'down payment' => 'Down Payment',
                    ])
                    ->disabled(),
                    TextInput::make('payment')
                    ->prefix('₱')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->rules(($this->balance < $this->down_payment) ?
                    'numeric|min:'.$this->balance.'|numeric|max:'.$this->balance :
                    'numeric|min:'.$this->down_payment.'|numeric|max:'.$this->balance)
                    ->extraInputAttributes(['style' => 'text-align:right; font-weight: bold;',
                     'placeholder' => '0.00',
                     'text-size' => 'xl'])
                    ->required()
                    ->autofocus(),
                ])->columns(2),
                // Fieldset::make('Billing Information')
                // ->schema([

                // ])->columns(2),
            ])
            ->statePath('data');
    }

    public function redirectToStatement()
    {
        return redirect()->route('filament.cashier.resources.students.view_statement', $this->record);
    }


    public function addBilling()
    {
        $total = (float) str_replace(',', '', $this->total);
        $balance = (float) str_replace(',', '', $this->balance);
        $payment = (float) str_replace(',', '', $this->data['payment']);
        $this->validate();

        DB::beginTransaction();
        $this->record->transactions()->create([
            'payment_type' => $this->data['payment_type'],
            'total' => $total,
            'balance' => ($balance - $payment),
            'amount_paid' => $payment,
        ]);


        $this->record->transactions()->latest()->first()->invoice()->create([
            'invoice_number' => 'INV-'.date('Y').'-'.date('m').'-'.date('d').'-'.date('H').'-'.date('i').'-'.date('s').'-'.rand(1000, 9999),
        ]);
        DB::commit();
        Notification::make()
        ->title('Success')
        ->success()
        ->body('Billing has been added successfully.')
        ->send();

        Mail::to($this->record->email)->send(new InvoiceMail($this->record->transactions()->latest()->first()));
        Notification::make()
        ->title('Success')
        ->success()
        ->body('E-Invoice is sent to students email.')
        ->send();

        $this->redirect(TransactionResource::getUrl('view_invoice', [$this->record->transactions()->latest()->first()->id]));
    }
}
