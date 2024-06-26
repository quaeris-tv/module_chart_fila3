<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Pages;

use Filament\Pages\Page;
use Modules\Chart\Filament\Widgets\Samples as WidgetsSamples;

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

    public function getHeaderWidgets(): array
    {
        return [
            WidgetsSamples\Bar02Chart::make(),
<<<<<<< HEAD
            WidgetsSamples\OverlookWidget::make(),
=======
>>>>>>> 6cf35d5 (add new version of stat chart)
            WidgetsSamples\OverlookV2Widget::make(),
            WidgetsSamples\Doughnut01Chart::make(),
            WidgetsSamples\Sample01Chart::make(),
        ];
    }
}
