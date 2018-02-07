<?php

namespace OCA\HyperLog\Storage;

use OC\Files\Storage\Wrapper\Wrapper;
use OCA\HyperLog\Service\LogService;
use OCP\IUser;

/**
 * Class LogWrapper
 * @package OCA\HyperLog\Storage
 *
 * Storage wrapper used to log download events
 */
class LogWrapper extends Wrapper {
    /** @var LogService */
    private $logService;
    /** @var  IUser */
    private $user;

    public function __construct($parameters) {
        // @TODO: suppress warning in log file
        //parent::$logWarningWhenAddingStorageWrapper = false;
        parent::__construct($parameters);
        $this->storage = $parameters['storage'];
        $this->logService = $parameters['logService'];
        $this->user = $parameters['user'];
    }

    /**
     * Log file downloads
     * @param string $path
     * @param string $mode
     * @return false|resource
     */
    public function fopen($path, $mode) {
        $uid = $this->user instanceof IUser ? $this->user->getUID() : 'OwnCloud (System)';

        if('rb' === $mode) {
            $this->logService->log(sprintf('%s von User %s heruntergeladen', $path, $uid),
                ['path' => $path, 'mode' => $mode, 'user' => $uid]);
        }

        $source = $this->storage->fopen($path, $mode);
        return $source;
    }

}