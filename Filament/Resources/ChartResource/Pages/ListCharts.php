<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\ChartResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Modules\Chart\Filament\Resources\ChartResource;

class ListCharts extends ListRecords
{
    protected static string $resource = ChartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
