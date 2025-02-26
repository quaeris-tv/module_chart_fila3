<?php

declare(strict_types=1);

namespace Modules\Chart\Tables\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Contracts\View\View;
use Modules\Chart\Datas\AnswersChartData;

use function Safe\json_encode;

// use Illuminate\Session\SessionManager;

class ChartColumn extends Column
{
    protected static ?string $heading = null;

    protected static ?string $maxHeight = null;

    protected static ?array $options = null;

    // class ChartColumn extends Component
    public string $dataChecksum;

    public ?string $filter = null;

    // protected string $view='filament::widgets.chart-widget';
    // protected $listeners = ['refreshChartColumn' => '$refresh'];
    public array $chartData = [
        'datasets' => [
            [
                'label' => 'loading...',
                'data' => [],
            ],
        ],
        'labels' => [],
    ];

    public string $chartType = 'bar';

    public array $chartOptions = [];

    protected ?array $cachedData = null;

    protected string $view = 'chart::tables.columns.chart-column';

    public function setAnswersChartData(AnswersChartData $answersChartData): self
    {
        $this->chartData = $answersChartData->getChartJsData();
        $this->chartType = $answersChartData->getChartJsType();
        $this->chartOptions = $answersChartData->getChartJsOptions();
        $this->cachedData = null;

        // dddx([$this->getCachedData(),$this->getData()]);
        // $this->emit('refreshChartColumn');
        // filterChartData
        return $this;
    }

    public function render(): View
    {
        $view_params = [
            'obj' => $this,
        ];

        return view($this->view, $view_params);
    }

    public function getCachedData(): array
    {
        return $this->cachedData ??= $this->getData();
    }

    public function getMaxHeight(): ?string
    {
        return static::$maxHeight;
    }

    public function getOptions(): ?array
    {
        return $this->chartOptions;
    }

    public function getType(): string
    {
        return $this->chartType;
    }

    public function updateChartData(): void
    {
        $newDataChecksum = $this->generateDataChecksum();

        if ($newDataChecksum !== $this->dataChecksum) {
            $this->dataChecksum = $newDataChecksum;

            // Assert::methodNotExists($this, 'emitSelf', $message = 'function emitSelf not exists');
            // NON E' LIVEWIRE
            // $this->emitSelf('updateChartData', [
            //    'data' => $this->getCachedData(),
            // ]);
        }
    }

    public function updatedFilter(): void
    {
        $newDataChecksum = $this->generateDataChecksum();

        if ($newDataChecksum !== $this->dataChecksum) {
            $this->dataChecksum = $newDataChecksum;

            // NON E' LIVEWIRE
            // $this->emitSelf('updateChartData', [
            //    'data' => $this->getCachedData(),
            // ]);
        }
    }

    public function getHeading(): ?string
    {
        return static::$heading;
    }

    protected function generateDataChecksum(): string
    {
        return md5(json_encode($this->getCachedData()));
    }

    protected function getData(): array
    {
        return $this->chartData;
    }

    protected function getFilters(): ?array
    {
        return null;
    }
}
