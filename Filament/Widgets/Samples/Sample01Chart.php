<?php

namespace Modules\Chart\Filament\Widgets\Samples;

use Filament\Widgets\ChartWidget;
use Filament\Support\RawJs;

class Sample01Chart extends ChartWidget
{
    protected static ?string $heading = 'Blog Posts';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    //'label' => 'Blog posts created',
                    'data' => [50, 60, 70, 180, 190],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['January', 'February', 'March', 'April', 'May'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
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

    /*
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'datalabels'=> [
                    'display'=> true,
                    'backgroundColor'=> '#ccc',
                    'borderRadius'=> 3,
                    'font'=> [
                      'color'=> 'red',
                      'weight'=> 'bold',
                    ],
                ],
                  'doughnutlabel'=> [
                    'labels'=> [
                      [
                        'text'=> '550',
                        'font'=> [
                          'size'=> 20,
                          'weight'=> 'bold',
                        ],
                        ],
                      [
                        'text'=> 'total',
                      ],
                    ],
                ],
            ],
        ];

    }
    */
    /*
    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
            {
                datalabels: {
                    display: true,
                    backgroundColor: '#ccc',
                    borderRadius: 3,
                    font: {
                    color: 'red',
                    weight: 'bold',
                    },
                },
                doughnutlabel: {
                    labels: [
                    {
                        text: '550',
                        font: {
                        size: 20,
                        weight: 'bold',
                        },
                    },
                    {
                        text: 'total',
                    },
                    ],
                },
            }
        JS);
    }
    */




}
