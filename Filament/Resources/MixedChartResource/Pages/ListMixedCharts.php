<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\MixedChartResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Chart\Filament\Resources\MixedChartResource;

class ListMixedCharts extends ListRecords
{
    protected static string $resource = MixedChartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
