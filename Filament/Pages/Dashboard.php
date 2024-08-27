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
            // WidgetsSamples\OverlookWidget::make(),
            // WidgetsSamples\OverlookV2Widget::make(),
=======
            WidgetsSamples\OverlookV2Widget::make(),
>>>>>>> 69cb5000f88139c7b4138a48ba51c27dada086c8
            WidgetsSamples\Doughnut01Chart::make(),
            WidgetsSamples\Sample01Chart::make(),
        ];
    }
}
