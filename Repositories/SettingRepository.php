<?php

namespace Modules\Setting\Repositories;

use Modules\Core\Repositories\BaseRepository;

interface SettingRepository extends BaseRepository
{
    /**
     * Create or update the settings
     * @param $settings
     * @return void
     */
    public function createOrUpdate($settings): void;

    /**
     * Find a setting by its name
     * @param string $settingName
     * @return mixed
     */
    public function findByName(string $settingName): mixed;

    /**
     * Return all modules that have settings
     * with its settings
     * @param array|string $modules
     * @return array
     */
    public function moduleSettings(array|string $modules): array;

    /**
     * Return the saved module settings
     * @param $module
     * @return mixed
     */
    public function savedModuleSettings($module): mixed;

    /**
     * Find settings by module name
     * @param string $module
     * @return mixed
     */
    public function findByModule(string $module): mixed;

    /**
     * Find the given setting name for the given module
     * @param string $settingName
     * @return mixed
     */
    public function get(string $settingName): mixed;

    /**
     * Return the translatable module settings
     * @param $module
     * @return array
     */
    public function translatableModuleSettings($module): array;

    /**
     * Return the non translatable module settings
     * @param $module
     * @return array
     */
    public function plainModuleSettings($module): array;
}
