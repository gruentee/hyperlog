<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 20.11.17
 * Time: 20:13
 */

namespace OCA\HyperLog\Controller;

use OCA\HyperLog\Hook\FileHooks;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\IConfig;
use OCP\IRequest;
use OCP\Template;
use Punic\Exception;

class Settings extends Controller {
    /**
     * @var IConfig
     */
    private $config;

    public function __construct($appName, IRequest $request, IConfig $config) {
        parent::__construct($appName, $request);
        $this->config = $config;
    }

    /**
     * @param $logFileName
     */
    public function updateLogFileName($logFileName) {
        $this->config->setAppValue($this->appName, 'logFileName', $logFileName);
    }

    /**
     * @param $hook
     * @return string (active|inactive)
     * @throws \Exception
     */
    public function getHookState($hook) {
        if (false === in_array($hook, FileHooks::HOOKS, true)) {
            throw new \Exception('$hook parameter must be one of ' . implode(', ', FileHooks::HOOKS));
        } else {
            return $this->config->getAppValue($this->appName, $hook);
        }
    }

    /**
     * Return JSON-encoded array with hook => state pairs
     * @return DataResponse
     */
    public function getHookStates() {
        $states = [];
        foreach (FileHooks::HOOKS as $hook) {
            try {
                $states[$hook] = $this->getHookState($hook);
            } catch (\Exception $e) {
                $states[$hook] = 'error retrieving hook state';
            }
        }
        return new DataResponse($states);
    }

    /**
     * @param $hook string one of \OCA\HyperLog\Hook\FileHooks::HOOKS
     * @param $status string one of \OCA\HyperLog\Hook\FileHooks::STATES
     * @return bool
     */
    public function setHookStatus($hook, $status) {
        if (false === in_array($hook, FileHooks::HOOKS, true)) {
            throw new \InvalidArgumentException('$hook parameter must be one of ' . implode(', ', FileHooks::HOOKS));
        } else if (false === in_array($status, FileHooks::STATES, true)) {
            throw new \InvalidArgumentException('$status parameter must be one of ' . implode(', ', FileHooks::STATES));
        } else {
            try {
                $this->config->setAppValue($this->appName, $hook, $status);
                return true;
            } catch (Exception $e) {
                return false;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function displayPanel() {
        $tmpl = new Template('hyperlog', 'settings-admin');
        $tmpl->assign('logFileName', $this->config->getAppValue($this->appName, 'logFileName'));
        return $tmpl;
    }
}