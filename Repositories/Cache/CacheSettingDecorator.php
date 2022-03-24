<?php

namespace Modules\Setting\Repositories\Cache;

use Illuminate\Cache\NullStore;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Setting\Repositories\SettingRepository;

class CacheSettingDecorator extends BaseCacheDecorator implements SettingRepository
{
    public function __construct(SettingRepository $setting)
    {
        parent::__construct();
        $this->entityName = 'setting.settings';
        $this->repository = $setting;
    }

    /**
     * Create or update the settings
     * @param $settings
     * @return void
     */
    public function createOrUpdate($settings): void
    {

        $this->clearCache();

        $this->repository->createOrUpdate($settings);
    }

    /**
     * Find a setting by its name
     * @param string $settingName
     * @return mixed
     */
    public function findByName(string $settingName): mixed
    {
        $settingValue = $this->remember(function () use ($settingName) {
            return $this->repository->findByName($settingName) ?? $settingName . '___NULL';
        });

        if ($settingValue === $settingName . '___NULL') $settingValue = null;

        return $settingValue;
    }

    /**
     * Return all modules that have settings
     * with its settings
     * @param array|string $modules
     * @return array
     */
    public function moduleSettings(array|string $modules): array
    {
        return $this->remember(function () use ($modules) {
            return $this->repository->moduleSettings($modules);
        },$this->entityName);
    }

    /**
     * Return the saved module settings
     * @param $module
     * @return mixed
     */
    public function savedModuleSettings($module): mixed
    {
        return $this->remember(function () use ($module) {
            return $this->repository->savedModuleSettings($module);
        });
    }

    /**
     * Find settings by module name
     * @param string $module
     * @return mixed
     */
    public function findByModule(string $module): mixed
    {
        return $this->remember(function () use ($module) {
            return $this->repository->findByModule($module);
        });
    }

    /**
     * Find the given setting name for the given module
     * @param string $settingName
     * @return mixed
     */
    public function get(string $settingName): mixed
    {
        return $this->remember(function () use ($settingName) {
            return $this->repository->get($settingName);
        });
    }

    /**
     * Return the translatable module settings
     * @param $module
     * @return array
     */
    public function translatableModuleSettings($module): array
    {
        return $this->remember(function () use ($module) {
            return $this->repository->translatableModuleSettings($module);
        });
    }

    /**
     * Return the non translatable module settings
     * @param $module
     * @return array
     */
    public function plainModuleSettings($module): array
    {
        return $this->remember(function () use ($module) {
            return $this->repository->plainModuleSettings($module);
        });
    }
}
