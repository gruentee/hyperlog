<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 08.11.17
 * Time: 16:26
 */

namespace OCA\HyperLog\Hook;


class FileHooks {
    private $folder;

    public function __construct($folder, $logService) {
        $this->folder = $folder;
        $this->logService = $logService;
    }

    public function register() {
        $callback = function ($node) {
            // TODO: implement logging for file system events
        };
        // TODO: register listeners for file system events
    }
}