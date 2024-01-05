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
        $monthlySum = Transaction::selectRaw('MONTH(created_at) as month, SUM(amount_paid) as total_amount')
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->get();
            $data = Trend::model(Transaction::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Sales Per Month',
                    'data' => $monthlySum->map(fn ($item) => $item->total_amount),
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
