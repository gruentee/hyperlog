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
use OCP\Files\IRootFolder;
use OCP\IConfig;

class LogService {

    private $log;
    /** @var  \OCP\IConfig */
    private $config;
    private $rootFolder;

    public function __construct(IConfig $config, IRootFolder $root) {
        $this->config = $config;
        $this->rootFolder = $root;
        // TODO: clear log (remove entries older than X days)

        // TODO: determine logging destination e.g. DB, File, 3rd-party service

        $this->log = new Logger('HyperLog');
        $logFileName = $this->config->getAppValue('hyperlog', 'logFileName');
        $this->log->pushHandler(new StreamHandler($logFileName, Logger::INFO));
    }

    public function log($message, $data = []) {
        $this->log->info($message, $data);
    }

}