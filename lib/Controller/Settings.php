<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 20.11.17
 * Time: 20:13
 */

namespace OCA\HyperLog\Controller;


use OCP\AppFramework\Controller;
use OCP\IConfig;
use OCP\IRequest;
use OCP\Template;

class Settings extends Controller {


    public function __construct($appName, IRequest $request, IConfig $config) {
        parent::__construct($appName, $request);
        $this->config = $config;
    }


    public function updateLogFileName($logFileName) {
        // TODO: implement log file
        $this->config->setAppValue($this->appName, 'logFileName', $logFileName);
    }

    public function getLogFileName($logFileName) {

    }

    public function displayPanel() {
        $tmpl = new Template('hyperlog', 'settings-admin');
        $tmpl->assign('logFileName', $this->config->getAppValue($this->appName, 'logFileName'));
        return $tmpl;
    }
}