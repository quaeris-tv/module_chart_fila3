<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\MixedChartResource\Pages;

use Modules\Chart\Filament\Resources\MixedChartResource;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListMixedCharts extends XotBaseListRecords
{
    protected static string $resource = MixedChartResource::class;

    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;

    public function getListTableColumns(): array
    {
        return [
        ];
    }
}
