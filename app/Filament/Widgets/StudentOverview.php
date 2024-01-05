<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Student;
use App\Models\Transaction;

class StudentOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
        Stat::make('Students', Student::count())
            ->description('Number of enrolled students')
            ->descriptionIcon('heroicon-m-users')
            ->color('primary'),
        Stat::make('Overall Transactions', Transaction::count())
            ->description('Number of all transactions')
            ->descriptionIcon('heroicon-m-arrows-right-left')
            ->color('warning'),
        Stat::make('Overall Sales', '₱ '.number_format(Transaction::sum('amount_paid'), 2))
            ->description('Total sales')
            ->descriptionIcon('heroicon-m-currency-dollar')
            ->color('success'),
        ];
    }
}
