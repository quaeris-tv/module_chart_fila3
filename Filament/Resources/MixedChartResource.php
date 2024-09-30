<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Modules\Chart\Filament\Resources\MixedChartResource\Pages\CreateMixedChart;
// use Modules\Chart\Filament\Resources\MixedChartResource\RelationManagers;
use Modules\Chart\Filament\Resources\MixedChartResource\Pages\EditMixedChart;
// use Filament\Forms;
use Modules\Chart\Filament\Resources\MixedChartResource\Pages\ListMixedCharts;
use Modules\Chart\Models\MixedChart;

// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class MixedChartResource extends Resource
{
    protected static ?string $model = MixedChart::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //         ])
    //         ->filters([
    //         ])
    //         ->actions([
    //             EditAction::make(),
    //         ])
    //         ->bulkActions([
    //             BulkActionGroup::make([
    //                 DeleteBulkAction::make(),
    //             ]),
    //         ])
    //         ->emptyStateActions([
    //             // {{ tableEmptyStateActions }}
    //         ]);
    // }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMixedCharts::route('/'),
            'create' => CreateMixedChart::route('/create'),
            'edit' => EditMixedChart::route('/{record}/edit'),
        ];
    }
}
