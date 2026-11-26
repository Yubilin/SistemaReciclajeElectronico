<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class WelcomeWidget extends Widget
{
    protected static string $view = 'filament.widgets.welcome';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = -2;
}