<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
// use Modules\Chart\Filament\Resources\ChartResource\RelationManagers;
use Filament\Tables\Actions\EditAction;
// use Filament\Forms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Modules\Chart\Actions\Chart\GetTypeOptions;
use Modules\Chart\Filament\Resources\ChartResource\Pages\CreateChart;
use Modules\Chart\Filament\Resources\ChartResource\Pages\EditChart;
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
                Select::make('type')->options(app(GetTypeOptions::class)->execute()),
                Select::make('group_by')->options([null => '---', 'date:o-W' => 'Settimanale', 'date:Y-M' => 'Mensile', 'date:Y-M-d' => 'Giornaliero', 'field:Q41' => 'field:Q41']),
                Select::make('sort_by')->options([null => '---', 'date:o-W' => 'Settimanale', 'date:Y-m' => 'Mensile', 'date:Y-m-d' => 'Giornaliero', '_value' => '_value', 'field:Q41' => 'field:Q41']),
                TextInput::make('width'),
                TextInput::make('height'),
                Toggle::make('show_box')->inline(false),

                // Forms\Components\TextInput::make('bg_color'),

                Select::make('font_family')->options([
                    10 => 'FF_COURIER',
                    11 => 'FF_VERDANA',
                    12 => 'FF_TIMES',
                    14 => 'FF_COMIC',
                    15 => 'FF_ARIAL',
                    16 => 'FF_GEORGIA',
                    17 => 'FF_TREBUCHE',
                    // 18 => 'FF_COLIBRI',
                ]),
                Select::make('font_style')->options([
                    9001 => 'FS_NORMAL',
                    9002 => 'FS_BOLD',
                    9003 => 'FS_ITALIC',
                    // 9004 => 'FS_BOLDIT',
                    9004 => 'FS_BOLDITALIC',
                ]),
                Select::make('font_size')->options([
                    '8' => '8',
                    '10' => '10',
                    '12' => '12',
                    '14' => '14',
                    '16' => '16',
                    '18' => '18',
                ]),

                // Forms\Components\TextInput::make('backtop'),
                // Forms\Components\TextInput::make('backbottom'),
                // Forms\Components\TextInput::make('backleft'),
                // Forms\Components\TextInput::make('backright'),
                // Forms\Components\TextInput::make('font_size_question'),
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
