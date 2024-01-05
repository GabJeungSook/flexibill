<?php

namespace App\Filament\Cashier\Widgets;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CashierOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
        Stat::make('Students', Student::count())
            ->description('Number of enrolled students')
            ->descriptionIcon('heroicon-m-users')
            ->color('primary'),
        Stat::make('Transactions Today', Transaction::whereDate('created_at', Carbon::today())->count())
            ->description('Number of all transactions')
            ->descriptionIcon('heroicon-m-arrows-right-left')
            ->color('warning'),
        Stat::make('Sales Today', '₱ '.number_format(Transaction::whereDate('created_at', Carbon::today())->sum('amount_paid'), 2))
            ->description('Total sales')
            ->descriptionIcon('heroicon-m-currency-dollar')
            ->color('success'),
        ];
    }
}
