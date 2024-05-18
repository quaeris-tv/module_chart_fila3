<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

class AnswersChartData extends Data
{
    public int $tot = 0;

    public string $title = 'no_set';

    public string $footer = 'no_set';

    public int $tot_answered = 0;

    public int $tot_invited = 0;

    /**
     * @var DataCollection<AnswerData>
     */
    public DataCollection $answers;

    public ChartData $chart;

    public function getChartJsType(): string
    {
        $type = $this->chart->type;
        switch ($type) {
            case 'pieAvg': // questa è una media ha un solo valore
                $type = 'doughnut';
                break;
            case 'horizbar1':
                $type = 'bar';
                break;
            case 'pie1':
                $type = 'doughnut';
                break;
            case 'lineSubQuestion':
                $type = 'line';
                break;
            case 'bar2':
            case 'bar1':
            case 'bar3':
                $type = 'bar';
                break;

            default:
                // dddx([
                //    'type' => $type,
                //    'chart' => $this->chart,
                // ]);
                break;
        }

        return $type;
    }

    public function getChartJsData(): array
    {
        $datasets = [];
        $data = $this->answers->toCollection()->pluck('value')->all();

        if (in_array($this->chart->type, ['pieAvg', 'pie1'], false)) {
            $data = $this->answers->toCollection()->pluck('avg')->all();

            if (isset($this->chart->max)) {
                $sum = collect($data)->sum();
                $other = $this->chart->max - $sum;
                if ($other > 0.01) {
                    $data[] = $other;
                    $labels[] = $this->chart->answer_value_no_txt ?? 'answer_value_no_txt';
                    if (\count($labels) === 2 && \strlen($labels[0]) < 3) {
                        $labels[0] = $this->chart->answer_value_txt;
                    }
                }
            }
        }

        if (isset($data[0]) && is_array($data[0])) { // questionario multiplo
            // dddx([$this->chart, $this->answers]);
            $legends = array_keys($data[0]);
            foreach ($legends as $key => $legend) {
                $tmp = [
                    'label' => $legend,
                    'data' => array_column($data, $legend),
                    'borderColor' => $this->chart->getColorsRgba(0.2)[$key] ?? null,
                    'backgroundColor' => $this->chart->getColorsRgba(0.2)[$key] ?? null,
                ];
                $datasets[] = $tmp;
            }
        } else {
            $data = $this->answers->toCollection()->pluck('avg')->all();
            foreach ($data as $key => $item) {
                $data[$key] = number_format((float) $item, 2, '.', '');
            }

            if (isset($this->chart->max)) {
                $sum = collect($data)->sum();
                $other = $this->chart->max - $sum;
                if ($other > 0.01) {
                    $data[] = $other;
                    $labels[] = $this->chart->answer_value_no_txt ?? 'answer_value_no_txt';
                    Assert::notNull($labels[0], '['.__FILE__.']['.__LINE__.']');
                    if (\count($labels) === 2 && \strlen($labels[0]) < 3) {
                        $labels[0] = $this->chart->answer_value_txt;
                    }
                }
            }

            if (isset($this->answers->toCollection()->pluck('avg')[0]) && ! is_string($this->answers->toCollection()->pluck('avg')[0])) {
                $label = 'Media';
            } else {
                $label = 'Percentuale';
            }

            $datasets = [
                [
                    // 'label' => ['Percentuale'],
                    'label' => [$label],
                    'data' => $data,
                    'borderColor' => $this->chart->getColorsRgba(0.2),
                    'backgroundColor' => $this->chart->getColorsRgba(0.2),
                ],
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $this->answers->toCollection()->pluck('label')->all(),
            // 'labels' => ['tasso'],
        ];
    }

    public function getChartJsOptions(): array
    {
        $title = [];

        if ($this->title !== 'no_set') {
            $title = [
                'display' => true,
                'text' => $this->title,
                'font' => [
                    'size' => 14,
                ],
            ];
        }

        if ($this->footer !== 'no_set') {
            $title = [
                'display' => true,
                'text' => $this->footer,
                'position' => 'bottom',
            ];
        }

        $options['plugins'] = [
            'title' => $title,
        ];

        if ($this->chart->type === 'horizbar1') {
            $options['indexAxis'] = 'y';
        }

        if ($this->chart->type === 'pieAvg' || $this->chart->type === 'pie1') {
            $options['scales'] = [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'display' => false, // Questa opzione nasconde i numeri sull'asse X
                    ]
                ],
                'y' => [
                    'grid' => [
                        'display' => false,
                    ],
                    'ticks' => [
                        'display' => false, // Questa opzione nasconde i numeri sull'asse Y
                    ]
                ]
            ];

            $options['plugins']['datalabels'] = [
                'display' => false,
            ];
        }

        if($this->chart->type === 'bar2' || $this->chart->type === 'bar' || $this->chart->type === 'horizbar1'){
            $options['plugins']['datalabels'] = [
                'display' => true,
                'backgroundColor' => '#ccc',
                'borderRadius' => 3,
                'anchor' => 'start',
                'font' => [
                  'color' => 'red',
                  'weight' => 'bold',
                ],
            ];
            $options['plugins']['legend'] = [
                'display' => false,
            ];
        }

        // if($this->chart->type === 'bar2'){
        //     dddx([$this->chart->type, $this->answers]);
        //     $options['plugins']['datalabels']['labers'] = [
                    
        //         ];
        // }

        // if($this->chart->type === 'horizbar1'){
        //     $options['plugins']['datalabels'] = [
        //             'formatter'=> round((float) $this->answers->first()->avg, 2).'%',
        //         ];
        // }


        if($this->chart->type === 'pieAvg'){
            $options['plugins']['doughnutLabel'] = [
                    'label'=> round($this->answers->first()->avg, 2),
                ];
        }

        if($this->chart->type === 'pie1'){
            // dddx($this->answers->first());
            $options['plugins']['doughnutLabel'] = [
                'label'=> round((float) $this->answers->first()->avg, 2)
            ];
        }

        // $options['plugins']['tooltip']['title'] = [
        //     'display' => true,
        //     // 'title' => 'prova',
        //     'text' => 'provaaaa',
        // ];

        // dddx([$options, $this->chart->type]);
        return $options;

        // var options = {
        //     tooltips: {
        //             callbacks: {
        //                 label: function(tooltipItem) {
        //                     return "$" + Number(tooltipItem.yLabel) + " and so worth it !";
        //                 }
        //             }
        //         },
        //             title: {
        //                       display: true,
        //                       text: 'Ice Cream Truck',
        //                       position: 'bottom'
        //                   },
        //             scales: {
        //                 yAxes: [{
        //                     ticks: {
        //                         beginAtZero:true
        //                     }
        //                 }]
        //             }
        //     };

        // [plugins: [{
        //     id: "centerText"
        //     , afterDatasetsDraw(chart, args, options) {
        //         const {ctx, chartArea: {left, right, top, bottom, width, height}} = chart;

        //         ctx.save();

        //         var fontSize = width * 4.5 / 100;
        //         var lineHeight = fontSize + (fontSize * {{$take}} / 100);

        //         ctx.font = "bolder " + fontSize + "px Arial";
        //         ctx.fillStyle = "rgba(0, 0, 0, 1)";
        //         ctx.textAlign = "center";
        //         ctx.fillText("{{$average}}", width / 2, (height / 2 + top - (lineHeight)));
        //         ctx.restore();

        //         ctx.font = fontSize + "px Arial";
        //         ctx.fillStyle = "rgba(0, 0, 0, 1)";
        //         ctx.textAlign = "center";
        //         ctx.fillText("MEDIA", width / 2, (height / 2 + top) + fontSize - lineHeight);
        //         ctx.restore();

        //         ctx.font = fontSize + "px Arial";
        //         ctx.fillStyle = "rgba(0, 0, 0, 1)";
        //         ctx.textAlign = "center";
        //         ctx.fillText("COMPLESSIVA", width / 2, (height / 2 + top) + fontSize);
        //         ctx.restore();
        //     }
        // }]]
    }
}
