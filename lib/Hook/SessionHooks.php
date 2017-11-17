<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 06.11.17
 * Time: 16:45
 */

namespace OCA\HyperLog\Hook;

/**
 * Class SessionHooks
 *
 * Hier können Hooks registriert werden, die mit der Sitzung des aktuellen Users zu tun haben.
 *
 * @package OCA\Application\Hook
 */
class SessionHooks {

    private $session;
    private $logService;

    public function __construct($session, $logService) {
        $this->session = $session;
        $this->logService = $logService;
    }

    public function register() {

        $callbackSuccessfulLogin = function ($user) {
            $this->logService->log(
                sprintf('User %s erfolgreich eingeloggt.', $user->getDisplayName()),
                ["user" => $user->getDisplayName()]
            );
        };
        $callbackFailedLogin = function ($user) {
            $this->logService->log(
                sprintf('Login von User %s fehlgeschlagen.', $user->getDisplayName()),
                ["user" => $user]
            );
        };

        $this->session->listen('\OC\User', 'postLogin', $callbackSuccessfulLogin);
        $this->session->listen('\OC\User', 'failedLogin', $callbackFailedLogin);

    }
}