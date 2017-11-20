<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 20.11.17
 * Time: 20:04
 */

namespace OCA\HyperLog;


use OCP\Settings\ISettings;
use OCP\Template;

class AdminPanel implements ISettings {

    const PRIORITY = 10;

    /** @var AppInfo\Application */
    protected $app;

    public function __construct(\OCA\HyperLog\AppInfo\Application $app) {
        $this->app = $app;
    }

    public function getPanel() {
        $tmpl = new Template('hyperlog', 'settings-admin');

        return $tmpl;
    }

    public function getPriority() {
        return self::PRIORITY;
    }

    public function getSectionID() {
        return 'general';
    }
}