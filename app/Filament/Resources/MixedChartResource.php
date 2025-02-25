<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Modules\Chart\Models\MixedChart;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MixedChartResource extends XotBaseResource
{
    protected static ?string $model = MixedChart::class;

    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Nome del grafico'),
        ];
    }
}
