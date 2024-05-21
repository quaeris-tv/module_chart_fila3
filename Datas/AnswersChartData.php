<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;
use Spatie\LaravelData\DataCollection;

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
            case 'pie1':
            case 'pieAvg': // questa è una media ha un solo valore
                $type = 'doughnut';
                break;
            case 'lineSubQuestion':
                $type = 'line';
                break;
            case 'bar2':
            case 'bar1':
            case 'bar3':
            case 'horizbar1':
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

    public function getChartJsOptionsArray(): array
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

        $chartjs_type=$this->getChartJsType();
        $method='getChartJs'.Str::of($chartjs_type)->studly()->toString().'OptionsArray';
        $options=$this->{$method}($options);
 
        return $options;

        
    }


    public function getChartJsBarOptionsJs(string $js):string {
        $js=<<<JS
            plugins: {
                datalabels:{
                    display: true,
                    backgroundColor: '#ccc',
                    borderRadius:3,
                    anchor: 'start',
                    font: {
                        color: 'red',
                        weight: 'bold',
                    },
                },
                legend:{
                    display: false,
                }
            }
            JS;
        return $js;
    }

    public function getChartJsDoughnutOptionsJs(string $js):string {
        $label =round(floatval($this->answers->first()->avg), 2);
        $js=<<<JS
            scales: {
                x:{
                    grid:{
                        display:false,
                    },
                    ticks:{
                        display:false,
                    }
                },
                y:{
                    grid:{
                        display:false,
                    },
                    ticks:{
                        display:false,
                    }
                }
            },
            plugins:{
                datalabels: false,
                doughnutLabel:{
                    label: '$label',
                }
            }
        JS;
        return $js;
    }

    public function getChartJsBarOptionsArray(array $options):array{
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
        return $options;
    }

    public function getChartJsDoughnutOptionsArray(array $options):array{
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

        $options['plugins']['doughnutLabel'] = [
            'label'=> round(floatval($this->answers->first()->avg), 2),
        ];
        return $options;
    }


    public function getChartJsOptionsJs(): RawJs
    {
        
        $js='';
        $chartjs_type=$this->getChartJsType();
        $method='getChartJs'.Str::of($chartjs_type)->studly()->toString().'OptionsJs';
        $js=$this->{$method}($js);
 
        return RawJs::make('{
            '.$js.'
            }');
        /*
        return RawJs::make(<<<JS
            {
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => '€' + value,
                        },
                    },
                },
            }
        JS);
        */
    }
}
