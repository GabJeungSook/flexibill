<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Flowframe\Trend\Trend;
use App\Models\Transaction;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Sales Per Month';

    protected static string $color = 'info';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
            $data = Trend::model(Transaction::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('amount_paid');

        return [
            'datasets' => [
                [
                    'label' => 'Sales Per Month',
                    'data' => $data->map(fn ($item) => $item->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('M')),
        ];
    }

    public function getDescription(): ?string
    {
        return 'This shows the total sales per month.';
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
