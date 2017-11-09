<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 08.11.17
 * Time: 16:08
 */

namespace OCA\HyperLog\AppInfo;

use OCA\HyperLog\Hook\SessionHooks;
use OCP\AppFramework\App;

class Application extends App {

    public function __construct(array $urlParams = array()) {
        parent::__construct('hyperlog', $urlParams);

        $container = $this->getContainer();
        /**
         * Controllers
         */
        $container->registerService('SessionHooks', function ($c) {
            return new SessionHooks(
                $c->query('ServerContainer')->getUserSession()
            );
        });
        // Register hooks
        $container->query('SessionHooks')->register();
    }
}