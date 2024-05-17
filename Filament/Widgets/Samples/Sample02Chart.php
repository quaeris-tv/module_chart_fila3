<?php

namespace Modules\Chart\Filament\Widgets\Samples;

use Filament\Widgets\ChartWidget;
use Filament\Support\RawJs;

class Sample02Chart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => [50, 60, 70, 180, 190],
                ],
            ],
            'labels' => ['January', 'February', 'March', 'April', 'May'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }


    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'datalabels' => [
                    'display' => true,
                    'backgroundColor' => '#ccc',
                    'borderRadius' => 3,
                    'anchor' => 'start',
                    'font' => [
                      'color' => 'red',
                      'weight' => 'bold',
                    ],
                ],
            ],
        ];
    }
}
