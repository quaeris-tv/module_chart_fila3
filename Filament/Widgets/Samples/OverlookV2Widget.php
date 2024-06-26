<?php
<<<<<<< HEAD

declare(strict_types=1);
=======
>>>>>>> 6cf35d5 (add new version of stat chart)
/**
 * @see https://github.com/awcodes/overlook/blob/2.x/src/Widgets/OverlookWidget.php
 */

namespace Modules\Chart\Filament\Widgets\Samples;

use Awcodes\Overlook\Contracts\CustomizeOverlookWidget;
use Awcodes\Overlook\OverlookPlugin;
<<<<<<< HEAD
=======
use Exception;
>>>>>>> 6cf35d5 (add new version of stat chart)
use Filament\Widgets\Widget;
use NumberFormatter;

class OverlookV2Widget extends Widget
{
    protected static string $view = 'chart::filament.widgets.samples.overlook-v2';

<<<<<<< HEAD
    protected int|string|array $columnSpan = 'full';
=======
    protected int | string | array $columnSpan = 'full';
>>>>>>> 6cf35d5 (add new version of stat chart)

    public array $data = [];

    public array $excludes = [];

    public array $includes = [];

    public array $grid = [];

    public array $icons = [];

    /**
<<<<<<< HEAD
     * @throws \Exception
=======
     * @throws Exception
>>>>>>> 6cf35d5 (add new version of stat chart)
     */
    public function mount(): void
    {
        $this->data = $this->getData();

        if (empty($this->grid)) {
            $this->grid = [
                'default' => 2,
                'sm' => 2,
                'md' => 3,
                'lg' => 3,
                'xl' => 3,
                '2xl' => null,
            ];
        }
    }

    public function convertCount(string $number): string
    {
        /*
        if (OverlookPlugin::get()->shouldAbbreviateCount()) {
            $formatter = new NumberFormatter(
                app()->getLocale(),
                NumberFormatter::PATTERN_DECIMAL,
            );

            return $formatter->format($number);
        }
        */

        return $number;
    }

    public function formatRawCount(string $number): string
    {
        return number_format($number);
    }

    /**
<<<<<<< HEAD
     * @throws \Exception
     */
    public function getData(): array
    {
=======
     * @throws Exception
     */
    public function getData(): array
    {

>>>>>>> 6cf35d5 (add new version of stat chart)
        $includes = [];
        $excludes = [];
        $icons = $this->icons;

        $rawResources = filled($includes)
            ? $includes
            : filament()->getCurrentPanel()->getResources();

        return collect($rawResources)->filter(function ($resource) use ($excludes) {
            return ! in_array($resource, $excludes);
        })->transform(function ($resource) use ($icons) {
<<<<<<< HEAD
=======

>>>>>>> 6cf35d5 (add new version of stat chart)
            $customIcon = array_search($resource, $icons);

            $res = app($resource);

            $widgetQuery = $res->getEloquentQuery();

            if ($res instanceof CustomizeOverlookWidget) {
                $rawCount = $res->getOverlookWidgetQuery($widgetQuery)->count();
                $title = $res->getOverlookWidgetTitle();
            } else {
<<<<<<< HEAD
                $rawCount = 666; // $widgetQuery->count();
=======
                $rawCount = 666;//$widgetQuery->count();
>>>>>>> 6cf35d5 (add new version of stat chart)
                $title = ucfirst($res->getPluralModelLabel());
            }

            if ($res->canViewAny()) {
                return [
                    'name' => $title,
                    'raw_count' => $this->formatRawcount($rawCount),
                    'count' => $this->convertCount($rawCount),
<<<<<<< HEAD
                    'icon' => $customIcon ?: 'heroicon-o-envelope',
                    'url' => $res->getUrl('index'),
                ];
            }
        })
            ->filter()
            // ->when($plugin->shouldSortAlphabetical(), fn ($collection) => $collection->sortBy('name'))
=======
                    'icon' => $customIcon ?: $res->getNavigationIcon(),
                    'url' => $res->getUrl('index'),
                ];
            }

            return null;
        })
            ->filter()
            //->when($plugin->shouldSortAlphabetical(), fn ($collection) => $collection->sortBy('name'))
>>>>>>> 6cf35d5 (add new version of stat chart)
            ->values()
            ->toArray();
    }

    public static function getSort(): int
    {
<<<<<<< HEAD
        // return OverlookPlugin::get()->getSort();
=======
        //return OverlookPlugin::get()->getSort();
>>>>>>> 6cf35d5 (add new version of stat chart)
        return 1;
    }

    public function shouldShowTooltips(string $number): bool
    {
<<<<<<< HEAD
        // $plugin = OverlookPlugin::get();

        // return strlen($number) >= 4 && $plugin->shouldAbbreviateCount() && $plugin->shouldShowTooltips();
=======
        //$plugin = OverlookPlugin::get();

        //return strlen($number) >= 4 && $plugin->shouldAbbreviateCount() && $plugin->shouldShowTooltips();
>>>>>>> 6cf35d5 (add new version of stat chart)
        return true;
    }
}
