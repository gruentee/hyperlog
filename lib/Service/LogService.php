<?php

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

    /**
     * LogService constructor.
     * @param IConfig $config
     * @param IRootFolder $root
     * @param $appName
     */
    public function __construct(IConfig $config, IRootFolder $root, $appName) {
        $this->config = $config;
        $this->rootFolder = $root;
        $this->appName = $appName;
        // TODO: clear log (remove entries older than X days)

        // TODO: determine logging destination e.g. DB, File, 3rd-party service

        $this->log = new Logger('HyperLog');
        $logFileName = $this->config->getAppValue($this->appName, 'logFileName');
        $this->log->pushHandler(new StreamHandler($logFileName, Logger::INFO));
    }

    /**
     * @param $message
     * @param array $data
     */
    public function log($message, $data = []) {
        $this->log->info($message, $data);
    }

}