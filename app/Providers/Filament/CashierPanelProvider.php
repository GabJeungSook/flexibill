<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use App\Http\Middleware\CheckRole;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Filament\Cashier\Widgets\CashierOverview;
use App\Filament\Cashier\Widgets\CashierSalesChart;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Cashier\Resources\TransactionResource;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class CashierPanelProvider extends PanelProvider
{
    protected static ?string $title = 'Cashier Dashboard';

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('cashier')
            ->brandName('FlexiBill')
            ->darkMode(false)
            ->path('/')
            ->login()
            ->colors([
                'primary' => Color::Indigo,
                'gray' => Color::Blue,
                'success' => Color::Green,
            ])
            ->breadcrumbs(false)
            ->discoverResources(in: app_path('Filament/Cashier/Resources'), for: 'App\\Filament\\Cashier\\Resources')
            ->discoverPages(in: app_path('Filament/Cashier/Pages'), for: 'App\\Filament\\Cashier\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Cashier/Widgets'), for: 'App\\Filament\\Cashier\\Widgets')
            ->widgets([
                CashierOverview::class,
                CashierSalesChart::class,
                //Widgets\AccountWidget::class,
                //Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                // CheckRole::class,
                Authenticate::class,
            ])
            ->navigationItems([
                NavigationItem::make('Sales Repoort')
                    ->url(fn (): string => TransactionResource::getUrl('sales_report'))
                    ->icon('heroicon-o-presentation-chart-line')
                    ->group('Reports')
                    ->sort(3),
                // ...
            ]);;
    }
}
