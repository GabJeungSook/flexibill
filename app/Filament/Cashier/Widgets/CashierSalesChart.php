<?php

namespace App\Filament\Cashier\Widgets;

use Carbon\Carbon;
use App\Models\Transaction;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Flowframe\Trend\Trend;

class CashierSalesChart extends ChartWidget
{
    protected static ?string $heading = 'Sales Chart';

    protected static string $color = 'info';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $data = Trend::model(Transaction::class)
                    ->between(
                        start: now()->startOfMonth(),
                        end: now()->endOfMonth(),
                    )
                    ->perDay()
                    ->sum('amount_paid');
       return [
                'datasets' => [
                    [
                        'label' => 'Sales Per Day',
                        'data' => $data->map(fn ($item) => $item->aggregate),
                    ],
                ],
                'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M d')),
            ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
