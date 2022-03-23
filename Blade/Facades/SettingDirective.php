<?php

namespace Modules\Setting\Blade\Facades;

use Illuminate\Support\Facades\Facade;

final class SettingDirective extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'setting.setting.directive';
    }
}
