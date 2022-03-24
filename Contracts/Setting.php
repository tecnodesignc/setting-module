<?php

namespace Modules\Setting\Contracts;

interface Setting
{
    /**
     * Determine if the given configuration value exists.
     *
     * @param  string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Get the specified configuration value in the given language
     *
     * @param string $key
     * @param string|null $locale
     * @param mixed $default
     * @return null|string
     */
    public function get(string $key, string $locale = null, string $default = null): ?string;

    /**
     * Set a given configuration value.
     *
     * @param string $key
     * @param mixed $value
     * @return \Modules\Setting\Entities\Setting
     */
    public function set(string $key, mixed $value): \Modules\Setting\Entities\Setting;
}
