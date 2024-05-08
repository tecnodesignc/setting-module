<?php

namespace Modules\Setting\Http\Controllers\Api;

use Illuminate\Session\Store;
use Modules\Core\Http\Controllers\Api\BaseApiController;
use Modules\Core\Traits\CanRequireAssets;
use Modules\Setting\Http\Requests\SettingRequest;
use Modules\Setting\Repositories\SettingRepository;
use Modules\Setting\Transformers\SettingsTransformer;
use Nwidart\Modules\Contracts\RepositoryInterface;
use Nwidart\Modules\Module;

class SettingController extends BaseApiController
{
    use CanRequireAssets;

    /**
     * @var SettingRepository
     */
    private $setting;
    /**
     * @var RepositoryInterface
     */
    private $module;
    /**
     * @var Store
     */
    private $session;

    public function __construct(SettingRepository $setting, Store $session)
    {
        parent::__construct();

        $this->setting = $setting;
        $this->module = app('modules');
        $this->session = $session;
    }

    public function index()
    {
        try {
            $modulesWithSettings = $this->setting->moduleSettings($this->module->allEnabled());
            $response = ["data" => $modulesWithSettings];
        } catch (\Exception $e) {
            $status = $e->getCode();
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    public function store(SettingRequest $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->all();
             $this->setting->createOrUpdate($data);

            $response = ["data" => trans('setting::messages.settings saved')];

            \DB::commit();

        } catch (\Exception $e) {
            \DB::rollback();
            dd($e);
            $status = $e->getCode();
            $response = ["errors" => $e->getMessage()];
        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    public function getModuleSettings(Module $currentModule)
    {

        try {
            $translatableSettings = $this->setting->translatableModuleSettings($currentModule->getLowerName());
            $plainSettings = $this->setting->plainModuleSettings($currentModule->getLowerName());
            $dbSettings = $this->setting->savedModuleSettings($currentModule->getLowerName());
            $response = ["data" => SettingsTransformer::collection($dbSettings), 'translatableSettings' => $translatableSettings, 'plainSettings' => $plainSettings];
        } catch (\Exception $e) {
            $status = $e->getCode();
            $response = ["errors" => $e->getMessage()];
        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }
}
