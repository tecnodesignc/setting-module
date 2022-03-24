<?php

namespace Modules\Setting\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Media\Contracts\StoringMedia;
use Modules\Setting\Entities\Setting;

class SettingWasCreated implements StoringMedia
{
    /**
     * @var Setting
     */
    public Setting $setting;

    /**
     * @var array
     */
    public array $data;

    public function __construct(Setting $setting, $data)
    {
        $this->setting = $setting;
        $this->data = $data;
    }

    /**
     * Return the entity
     * @return Model
     */
    public function getEntity(): Model
    {
        return $this->setting;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
