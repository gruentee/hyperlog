<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 06.11.17
 * Time: 16:45
 */

namespace OCA\HyperLog\Hook;

use OCA\HyperLog\Service\LogService;

/**
 * Class SessionHooks
 *
 * Hier können Hook registriert werden, die mit der Sitzung des aktuellen Users zu tun haben.
 *
 * @package OCA\Application\Hook
 */
class SessionHooks {

    private $session;

    public function __construct($session) {
        $this->session = $session;
        $this->logService = new LogService();
    }

    public function register() {
//        $callback = function ($user) {
//            // TODO: implement logging for session events
//            $this->logService
//        };
        // TODO: register listeners for session events
        $callbackSuccessfulLogin = function ($user) {
            $this->logService->log("User $user erfolgreich eingeloggt.");
        };

        $this->session->listen('\OC\User', 'postLogin', $callbackSuccessfulLogin);

    }
}