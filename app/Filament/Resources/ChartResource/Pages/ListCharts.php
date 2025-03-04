<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources\ChartResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Chart\Filament\Resources\ChartResource;
use Modules\UI\Enums\TableLayoutEnum;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListCharts extends XotBaseListRecords
{
    protected static string $resource = ChartResource::class;

    public TableLayoutEnum $layoutView = TableLayoutEnum::LIST;

    public function getListTableColumns(): array
    {
        return [
            TextColumn::make('id'),
            TextColumn::make('type'),
            TextColumn::make('group_by'),
            TextColumn::make('sort_by'),
            TextColumn::make('width'),
            TextColumn::make('height'),
            TextColumn::make('font_family'),
            TextColumn::make('font_style'),
            TextColumn::make('font_size'),
        ];
    }
}
