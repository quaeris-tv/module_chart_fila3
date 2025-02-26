<?php

declare(strict_types=1);

namespace Modules\Chart\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class ChartServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Chart';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;
}
