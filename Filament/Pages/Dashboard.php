<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Pages;

use Filament\Pages\Page;
<<<<<<< HEAD
use Modules\Chart\Filament\Widgets\Samples as WidgetsSamples;
=======
>>>>>>> 001dc50 (.)

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'chart::filament.pages.dashboard';

    /*
    public function mount(): void {
        $user = auth()->user();
        if(!$user->hasRole('super-admin')){
            redirect('/admin');
        }
    }
    */
<<<<<<< HEAD

    public function getHeaderWidgets(): array
    {
        return [
            WidgetsSamples\Bar02Chart::make(),
            WidgetsSamples\OverlookWidget::make(),
            WidgetsSamples\Doughnut01Chart::make(),
            WidgetsSamples\Sample01Chart::make(),
        ];
    }
=======
>>>>>>> 001dc50 (.)
}
