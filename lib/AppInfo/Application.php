<?php

namespace OCA\HyperLog\AppInfo;

use OCA\HyperLog\Controller\Settings;
use OCA\HyperLog\Hook\FileHooks;
use OCA\HyperLog\Hook\SessionHooks;
use OCA\HyperLog\Service\LogService;
use OCA\HyperLog\Storage\LogWrapper;
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
        $container->registerService('LogService', function (IAppContainer $c) {
            return new LogService(
                $c->query('ServerContainer')->getConfig(),
                $c->query('ServerContainer')->getRootFolder(),
                $c->getAppName()
            );
        });

        $container->registerService('FileHooks', function (IAppContainer $c) {
            return new FileHooks(
                $c->query('ServerContainer')->getRootFolder(),
                $c->query('ServerContainer')->getUserSession()->getUser(),
                $c->query('LogService'),
                $c->query('ServerContainer')->getConfig(),
                $c->getAppName()
            );
        });

        $container->registerService('SessionHooks', function (IAppContainer $c) {
            return new SessionHooks(
                $c->query('ServerContainer')->getUserSession(),
                $c->query('LogService')
            );
        });

        /**
         * Controllers
         */

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
        $this->setupWrapper();
    }

    private function registerHooks() {
        $this->getContainer()->query('SessionHooks')->register();
        $this->getContainer()->query('FileHooks')->register();
    }

    private function setupWrapper() {
        $c = $this->getContainer();
        $logService = $c->query('LogService');
        $user = $c->query('ServerContainer')->getUserSession()->getUser();
        \OC\Files\Filesystem::addStorageWrapper('LogWrapper', function ($mountpoint, $storage) use  ($logService, $user) {
                return new LogWrapper(['storage' => $storage, 'logService' => $logService,
                    'user' => $user]);
            },
            1);
    }
}