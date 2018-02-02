<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 18.01.18
 * Time: 19:49
 */

namespace OCA\HyperLog\Storage\Wrapper;


use OC\Files\Storage\Wrapper\Wrapper;

/**
 * Class LogWrapper
 * @package OCA\HyperLog\Storage
 *
 * Storage wrapper used to log download events
 */
class LogWrapper extends Wrapper {
    private $logService;
    private $user;

    public function __construct($parameters) {
        $this->storage = $parameters['storage'];
        $this->logService = $parameters['logService'];
        $this->user = $parameters['user'];
    }

    public function fopen($path, $mode) {
        $source = $this->storage->fopen($path, $mode);

        if('r' === $mode) {
            $this->logService->log(sprintf('%s von User %s geöffnet', $path, $this->user->getUID()));
        }

        return $source;
    }
}