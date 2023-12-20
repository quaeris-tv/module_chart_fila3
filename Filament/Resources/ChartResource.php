<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Modules\Chart\Filament\Resources\ChartResource\Pages\CreateChart;
// use Modules\Chart\Filament\Resources\ChartResource\RelationManagers;
use Modules\Chart\Filament\Resources\ChartResource\Pages\EditChart;
// use Filament\Forms;
use Modules\Chart\Filament\Resources\ChartResource\Pages\ListCharts;
use Modules\Chart\Models\Chart;

// use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChartResource extends Resource
{
    protected static ?string $model = Chart::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ])
            ->filters([
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                // {{ tableEmptyStateActions }}
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCharts::route('/'),
            'create' => CreateChart::route('/create'),
            'edit' => EditChart::route('/{record}/edit'),
        ];
    }
}
