<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources;

use Modules\Chart\Models\MixedChart;
// use Modules\Chart\Filament\Resources\MixedChartResource\RelationManagers;
use Modules\Xot\Filament\Resources\XotBaseResource;

// use Filament\Forms;

// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class MixedChartResource extends XotBaseResource
{
    protected static ?string $model = MixedChart::class;

    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->placeholder('mixed_chart.placeholders.name'),

            'charts' => Select::make('charts')
                ->multiple()
                ->relationship('charts', 'name')
                ->preload()
                ->placeholder('mixed_chart.placeholders.charts'),
        ];
    }
}
