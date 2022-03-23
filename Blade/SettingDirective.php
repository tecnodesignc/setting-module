<?php

namespace Modules\Setting\Blade;

use Illuminate\Support\Arr;

final class SettingDirective
{
    /**
     * @var null|string
     */
    private null|string $settingName;
    /**
     * @var null|string
     */
    private null|string $locale;
    /**
     * @var null|string Default value
     */
    private null|string $default;

    /**
     * @param $arguments
     * @return string
     */
    public function show($arguments): string
    {
        $this->extractArguments($arguments);

        return e(setting($this->settingName, $this->locale, $this->default));
    }

    /**
     * @param array $arguments
     */
    private function extractArguments(array $arguments)
    {
        $this->settingName = Arr::get($arguments, 0);
        $this->locale = Arr::get($arguments, 1);
        $this->default = Arr::get($arguments, 2);
    }
}
