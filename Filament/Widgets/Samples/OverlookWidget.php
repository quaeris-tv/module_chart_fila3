<?php

declare(strict_types=1);
/**
 * @see https://github.com/awcodes/overlook/blob/2.x/src/Widgets/OverlookWidget.php
 */

namespace Modules\Chart\Filament\Widgets\Samples;

use Awcodes\Overlook\Contracts\CustomizeOverlookWidget;
use Awcodes\Overlook\OverlookPlugin;
use Filament\Widgets\Widget;
use NumberFormatter;

class OverlookWidget extends Widget
{
    protected static string $view = 'chart::filament.widgets.samples.overlook';

    protected int|string|array $columnSpan = 'full';

    public array $data = [];

    public array $excludes = [];

    public array $includes = [];

    public array $grid = [];

    public array $icons = [];

    /**
     * @throws \Exception
     */
    public function mount(): void
    {
        $this->data = $this->getData();

        if (empty($this->grid)) {
            $this->grid = [
                'default' => 2,
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
                'xl' => 5,
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
     * @throws \Exception
     */
    public function getData(): array
    {
        $includes = [];
        $excludes = [];
        $icons = $this->icons;

        $rawResources = filled($includes)
            ? $includes
            : filament()->getCurrentPanel()->getResources();

        return collect($rawResources)->filter(function ($resource) use ($excludes) {
            return ! in_array($resource, $excludes);
        })->transform(function ($resource) use ($icons) {
            $customIcon = array_search($resource, $icons);

            $res = app($resource);

            $widgetQuery = $res->getEloquentQuery();

            if ($res instanceof CustomizeOverlookWidget) {
                $rawCount = $res->getOverlookWidgetQuery($widgetQuery)->count();
                $title = $res->getOverlookWidgetTitle();
            } else {
                $rawCount = 666; // $widgetQuery->count();
                $title = ucfirst($res->getPluralModelLabel());
            }

            if ($res->canViewAny()) {
                return [
                    'name' => $title,
                    'raw_count' => $this->formatRawcount($rawCount),
                    'count' => $this->convertCount($rawCount),
                    'icon' => $customIcon ?: $res->getNavigationIcon(),
                    'url' => $res->getUrl('index'),
                ];
            }
        })
            ->filter()
            // ->when($plugin->shouldSortAlphabetical(), fn ($collection) => $collection->sortBy('name'))
            ->values()
            ->toArray();
    }

    public static function getSort(): int
    {
        // return OverlookPlugin::get()->getSort();
        return 1;
    }

    public function shouldShowTooltips(string $number): bool
    {
        // $plugin = OverlookPlugin::get();

        // return strlen($number) >= 4 && $plugin->shouldAbbreviateCount() && $plugin->shouldShowTooltips();
        return true;
    }
}
