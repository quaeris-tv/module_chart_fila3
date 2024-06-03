<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
=======
use Spatie\LaravelData\Data;
>>>>>>> 001dc50 (.)

class AnswerData extends Data
{
    public ?string $label = null;

    public int $gid = 0;

    public float|array $value = 0;

    public float|array|string $value1 = '';

    public ?string $_key = null;

    public ?string $key = null;

    public ?string $_sub = null;

    public ?string $_sort = null;

    // public ?array $sub_labels;
    // public $values; NO ! NO ! NO !
    public float|array|string $avg = 0;

    // public int $tot = 1;
    // public int $tot_nulled = 0;
    public ?string $title = null;

    public ?string $subtitle = null;
<<<<<<< HEAD

    public static function collection(EloquentCollection|array $data): DataCollection
    {
        return self::collect($data, DataCollection::class);
    }
=======
>>>>>>> 001dc50 (.)
}
