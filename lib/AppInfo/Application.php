<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 08.11.17
 * Time: 16:08
 */

namespace OCA\HyperLog\AppInfo;

use OCA\HyperLog\Hook\FileHooks;
use OCA\HyperLog\Hook\SessionHooks;
use OCA\HyperLog\Service\LogService;
use OCP\AppFramework\App;

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
            return new LogService();
        });

        $container->registerService('FileHooks', function ($c) {
            return new FileHooks(
                $c->query('ServerContainer')->getRootFolder(),
                $c->query('LogService')
            );
        });

        $container->registerService('SessionHooks', function ($c) {
            return new SessionHooks(
                $c->query('ServerContainer')->getUserSession(),
                $c->query('LogService')
            );
        });

        $this->registerHooks();
    }

    private function registerHooks() {
        $this->getContainer()->query('SessionHooks')->register();
        $this->getContainer()->query('FileHooks')->register();
    }
}