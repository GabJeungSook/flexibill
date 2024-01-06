<?php

namespace App\Filament\Cashier\Resources\TransactionReportResource\Pages;

use App\Filament\Cashier\Resources\TransactionReportResource;
use Filament\Resources\Pages\Page;
use App\Models\Transaction;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Carbon\Carbon;

class ReportTransaction extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = TransactionReportResource::class;

    protected static string $view = 'filament.cashier.resources.transaction-report-resource.pages.report-transaction';
    protected static ?string $title = 'Sales Report';
    public $record;
    public $from;
    public $to;

  
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                ->schema([
                    DatePicker::make('from')->native(false)->live()
                    ->afterStateUpdated(function ($state) {
                        if(isset($this->from) && isset($this->to))
                        {
                            $this->record = Transaction::whereDate('created_at', '>=', $this->from)
                            ->whereDate('created_at', '<=', $this->to)->get();
                        }
                    }),
                    DatePicker::make('to')->native(false)->live()
                    ->afterStateUpdated(function ($state) {
                        if(isset($this->from) && isset($this->to))
                        {
                            $this->record = Transaction::whereDate('created_at', '>=', $this->from)
                            ->whereDate('created_at', '<=', $this->to)->get();
                        }
                    })
                ])->columns(2)
            ]);
    }

    public function mount(): void
    {

        $this->record = Transaction::get();
        static::authorizeResourceAccess();
    }
}
