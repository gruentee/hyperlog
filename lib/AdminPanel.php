<?php

namespace OCA\HyperLog;


use OCP\Settings\ISettings;

class AdminPanel implements ISettings {

    const PRIORITY = 10;

    /** @var AppInfo\Application */
    protected $app;

    public function __construct(\OCA\HyperLog\AppInfo\Application $app) {
        $this->app = $app;
    }

    public function getPanel() {
        return $this->app->getContainer()->query('SettingsController')->displayPanel();
    }

    public function getPriority() {
        return self::PRIORITY;
    }

    public function getSectionID() {
        return 'general';
    }
}