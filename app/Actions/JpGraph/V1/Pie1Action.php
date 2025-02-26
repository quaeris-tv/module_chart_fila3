<?php

declare(strict_types=1);

namespace Modules\Chart\Actions\JpGraph\V1;

use Amenadiel\JpGraph\Graph\Graph;
use Amenadiel\JpGraph\Graph\PieGraph;
use Amenadiel\JpGraph\Plot\PiePlotC;
use Modules\Chart\Actions\JpGraph\ApplyGraphStyleAction;
use Modules\Chart\Datas\AnswersChartData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class Pie1Action
{
    use QueueableAction;

    public function execute(AnswersChartData $answersChartData): Graph
    {
        $labels = $answersChartData->answers->toCollection()->pluck('label')->all();
        $data = $answersChartData->answers->toCollection()->pluck('avg')->all();
        $chart = $answersChartData->chart;
        // dddx(['labels' => $labels, 'data' => $data, 'chart' => $chart]);

        if (isset($chart->max)) {
            Assert::numeric($sum = collect($data)->sum());
            Assert::numeric($chart->max);
            $other = $chart->max - $sum;
            // dddx([$sum, $other, $this->vars['max']]);
            if ($other > 0.01) {
                $data[] = $other;
                $labels[] = $chart->answer_value_no_txt;

                if (\count($labels) === 2 && \strlen((string) $labels[0]) < 3) {
                    $labels[0] = $chart->answer_value_txt;
                }
            }
        }

        // A new pie graph
        $graph = new PieGraph($chart->width, $chart->height, 'auto');
        // $graph = $this->getGraph();
        // $graph = $this->applyGraphStyle($graph);
        $graph = app(ApplyGraphStyleAction::class)->execute($graph, $chart);

        // Create the pie plot
        $piePlotC = new PiePlotC($data);

        // $p1->SetSliceColors(explode(',', $chart->list_color));
        // trasparenza da 0 a 1, inserito per ogni colore
        $color_array = explode(',', $chart->list_color);
        foreach ($color_array as $k => $color) {
            $color_array[$k] = $color.'@'.$chart->transparency;
        }

        $piePlotC->SetSliceColors($color_array);

        $piePlotC->SetLegends($labels);
        // $graph->legend->SetPos(0.5,0.98,'center','bottom');

        // Enable and set policy for guide-lines. Make labels line up vertically
        $piePlotC->SetGuideLines(true, false);
        $piePlotC->SetGuideLinesAdjust(1.5);

        // Use percentage values in the legends values (This is also the default)
        $piePlotC->SetLabelType(PIE_VALUE_PER);

        $piePlotC->value->Show();

        // $p1->SetMidSize(0.8);
        $piePlotC->SetMidSize($chart->plot_perc_width / 100);

        // $mandatory = $chart->mandatory;
        // if (null === $chart->mandatory) {
        //     $mandatory = 'null';
        // }

        $graph->title->Set($chart->title);
        $graph->title->SetFont($chart->font_family, $chart->font_style, 11);

        $graph->subtitle->Set($chart->subtitle);
        $graph->subtitle->SetFont($chart->font_family, $chart->font_style, 11);

        // Label font and color setup
        $piePlotC->value->SetFont(FF_ARIAL, FS_BOLD, 10);
        $piePlotC->value->SetColor('black');

        // Setup the title on the center circle
        $piePlotC->midtitle->Set('');
        $piePlotC->midtitle->SetFont(FF_ARIAL, FS_NORMAL, 10);

        $piePlotC->value->SetFormat('%2.1f%%');

        // Set color for mid circle
        $piePlotC->SetMidColor('white');

        // Add plot to pie graph
        $graph->Add($piePlotC);

        return $graph;
    }
}
