<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Auth\Login;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(Login::class)
            ->brandName('Panel de Administración - RAEE')
            ->navigationGroups([
                '1. Preparación',
                '2. Recepción de equipos',
                '3. Recuperación y componentes',
                '4. Inventario',
                '5. Administración',
            ])
            ->assets([
                Css::make('raee-admin-theme', asset('css/raee-admin-theme.css')),
            ])
            ->colors([
                'primary' => Color::hex('#659F17'),      // Fern
                'success' => Color::hex('#659F17'),      // Fern
                'danger'  => Color::hex('#dc2626'),      
                'warning' => Color::hex('#f59e0b'),      
                'info'    => Color::hex('#116D64'),      // Spruce
            ])
            ->brandLogo(asset('images/raee-symbol.png'))
            ->brandLogoHeight('3.5rem')
            ->favicon(asset('images/raee-symbol.png'))
            ->darkMode(true)
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            // ❌ ELIMINAMOS discoverWidgets para evitar duplicados o conflictos de grid
            ->widgets([
                \App\Filament\Widgets\WelcomeWidget::class,                // sort -2
                \App\Filament\Widgets\StatsWidget::class,                  // sort -1
                \App\Filament\Widgets\MaterialesPorCategoriaChart::class,  // sort 1
                \App\Filament\Widgets\RecepcionesRecientesChart::class,    // sort 3
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
                Authenticate::class,
            ]);
    }
}