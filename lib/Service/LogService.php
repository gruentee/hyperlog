<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 08.11.17
 * Time: 18:14
 */

namespace OCA\HyperLog\Service;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LogService {

    private $log;

    public function __construct() {
        // do constructor stuff
        // clear log (remove entries older than X days)

        // determine logging destination e.g. DB, File, 3rd-party service

        $this->log = new Logger('HyperLog');
        $this->log->pushHandler(new StreamHandler('hyper.log', Logger::INFO));
    }

    public function log($message, $data = []) {
        $this->log->info($message, $data);
    }

}