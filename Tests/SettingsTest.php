<?php

namespace Modules\Setting\Tests;

class SettingsTest extends BaseSettingTest
{
    /**
     * @var \Modules\Setting\Support\Settings
     */
    protected $setting;

    public function setUp(): void
    {
        parent::setUp();
        $this->setting = app('Modules\Setting\Support\Settings');
    }

    /** @test */
    public function it_gets_a_setting_without_locale()
    {
        // Prepare
        $data = [
            'core::site-name' => [
                'en' => 'EncoreCMS_en',
                'fr' => 'EncoreCMS_fr',
            ],
            'core::template' => 'encore',
            'blog::posts-per-page' => 10,
        ];

        // Run
        $this->settingRepository->createOrUpdate($data);

        // Assert
        $setting = $this->setting->get('core::site-name');
        $this->assertEquals('EncoreCMS_en', $setting);
    }

    /** @test */
    public function it_gets_setting_in_given_locale()
    {
        // Prepare
        $data = [
            'core::site-name' => [
                'en' => 'EncoreCMS_en',
                'fr' => 'EncoreCMS_fr',
            ],
            'core::template' => 'encore',
            'blog::posts-per-page' => 10,
        ];

        // Run
        $this->settingRepository->createOrUpdate($data);

        // Assert
        $setting = $this->setting->get('core::site-name', 'fr');
        $this->assertEquals('EncoreCMS_fr', $setting);
    }

    /** @test */
    public function it_returns_correctly_if_setting_is_falsey()
    {
        // Prepare
        $data = [
            'blog::posts-per-page' => 0,
        ];

        // Run
        $this->settingRepository->createOrUpdate($data);

        // Assert
        $setting = $this->setting->get('blog::posts-per-page');
        $this->assertEquals(0, $setting);
    }

    /** @test */
    public function it_returns_correctly_if_setting_for_locale_is_falsey()
    {
        // Prepare
        $this->app['config']->set('encore.block.settings', [
            'display-some-feature' => [
                'description' => 'block::settings.display-some-feature',
                'view' => 'text',
                'translatable' => true,
            ],
        ]);

        $data = [
            'block::display-some-feature' => [
                'en' => 0,
                'fr' => 1,
            ],
        ];

        // Run
        $this->settingRepository->createOrUpdate($data);

        // Assert
        $this->assertEquals(0, $this->setting->get('block::display-some-feature', 'en'));
        $this->assertEquals(1, $this->setting->get('block::display-some-feature', 'fr'));
    }

    /** @test */
    public function it_returns_a_default_value_if_no_setting_found()
    {
        // Prepare
        $setting = $this->setting->get('core::non-existing-setting', 'en', 'defaultValue');

        // Assert
        $this->assertEquals('defaultValue', $setting);
    }
}
