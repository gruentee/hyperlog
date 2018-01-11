<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 08.11.17
 * Time: 16:08
 */

namespace OCA\HyperLog\AppInfo;

use OCA\HyperLog\Controller\Settings;
use OCA\HyperLog\Hook\FileHooks;
use OCA\HyperLog\Hook\SessionHooks;
use OCA\HyperLog\Service\LogService;
use OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

class Application extends App {
    /**
     * Application constructor.
     * @param array $urlParams
     */
    public function __construct(array $urlParams = array()) {
        parent::__construct('hyperlog', $urlParams);

        $container = $this->getContainer();
        /**
         * Services
         */
        $container->registerService('LogService', function ($c) {
            return new LogService(
                $c->query('ServerContainer')->getConfig(),
                $c->query('ServerContainer')->getRootFolder(),
                $c->getAppName()
            );
        });

        $container->registerService('FileHooks', function ($c) {
            return new FileHooks(
                $c->query('ServerContainer')->getRootFolder(),
                $c->query('ServerContainer')->getUserSession()->getUser(),
                $c->query('LogService'),
                $c->query('ServerContainer')->getConfig(),
                $c->getAppName()
            );
        });

        $container->registerService('SessionHooks', function ($c) {
            return new SessionHooks(
                $c->query('ServerContainer')->getUserSession(),
                $c->query('LogService')
            );
        });

        $container->registerService('SettingsController', function (IAppContainer $c) {
            /** @var \OC\Server $server */
            $server = $c->query('ServerContainer');

            return new Settings(
                $c->getAppName(),
                $server->getRequest(),
                $server->getConfig()
            );
        });

        $this->registerHooks();
    }

    private function registerHooks() {
        $this->getContainer()->query('SessionHooks')->register();
        $this->getContainer()->query('FileHooks')->register();
    }
}