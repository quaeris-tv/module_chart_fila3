<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Quaeris\Models\QuestionChart;

/**
 * Modules\Chart\Models\MixedChart.
 *
 * @property Collection<int, \Modules\Chart\Models\Chart> $charts
 * @property int|null                                     $charts_count
 *
 * @method static \Modules\Chart\Database\Factories\MixedChartFactory factory($count = null, $state = [])
 * @method static Builder|MixedChart                                  newModelQuery()
 * @method static Builder|MixedChart                                  newQuery()
 * @method static Builder|MixedChart                                  query()
 *
 * @mixin \Eloquent
 */
class MixedChart extends BaseModel
{
    /** @var array<int, string> */
    protected $fillable = [
        'id',
        'name',
    ];

    // ---- relations

    public function charts(): MorphMany
    {
        Relation::morphMap([
            'question_chart' => QuestionChart::class,
            'mixed_chart' => self::class,
        ]);

        return $this->morphMany(Chart::class, 'post');
    }
}
