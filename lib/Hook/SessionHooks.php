<?php

namespace OCA\HyperLog\Hook;

use OCA\HyperLog\Service\LogService;
use OCP\IUserSession;

/**
 * Class SessionHooks
 *
 * Hier können Hooks registriert werden, die mit der Sitzung des aktuellen Users zu tun haben.
 *
 * @package OCA\Application\Hook
 */
class SessionHooks {
    /** @var IUserSession */
    private $session;
    /** @var LogService */
    private $logService;

    public function __construct($session, $logService) {
        $this->session = $session;
        $this->logService = $logService;
    }

    public function register() {

        $callbackSuccessfulLogin = function (\OCP\IUser $user) {
            $this->logService->log(
                sprintf('User %s erfolgreich eingeloggt.', $user->getDisplayName()),
                ["user" => $user->getDisplayName()]
            );
        };
        $callbackFailedLogin = function ($user) {
            $this->logService->log(
                sprintf('Login von User %s fehlgeschlagen.', $user),
                ["user" => $user]
            );
        };

        $this->session->listen('\OC\User', 'postLogin', $callbackSuccessfulLogin);
        $this->session->listen('\OC\User', 'failedLogin', $callbackFailedLogin);

    }
}