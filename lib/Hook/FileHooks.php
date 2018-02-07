<?php

namespace OCA\HyperLog\Hook;

use OCA\HyperLog\Service\LogService;
use OCP\Files\IRootFolder;
use OCP\Files\Node;
use OCP\IConfig;
use OCP\IUser;

class FileHooks {

    private $root;
    /** @var LogService */
    private $logService;
    private $config;

    const HOOKS = [
        'postWrite',
        'postCreate',
        'postDelete',
        'postTouch',
        'postCopy',
        'postRename'
    ];

    const STATES = [
        'active',
        'inactive'
    ];

    public function __construct(IRootFolder $root, $user, LogService $logService, IConfig $config, $appName) {
        $this->root = $root;
        $this->userName = $user instanceof IUser ? $user->getUID() : 'OwnCloud (System)';
        $this->logService = $logService;
        $this->config = $config;
        $this->appName = $appName;
    }

    public function register() {
        $reference = $this;

        $postWrite = function (Node $node) use ($reference) {
            $reference->postWrite($node);
        };
        $postCreate = function (Node $node) use ($reference) {
            $reference->postCreate($node);
        };
        $postDelete = function (Node $node) use ($reference) {
            $reference->postDelete($node);
        };
        $postTouch = function (Node $node) use ($reference) {
            $reference->postTouch($node);
        };
        $postCopy = function (Node $source, Node $target) use ($reference) {
            $reference->postCopy($source, $target);
        };
        $postRename = function (Node $source, Node $target) use ($reference) {
            $reference->postRename($source, $target);
        };

        // register listeners for file system events
        foreach (self::HOOKS as $hook) {
            $active = 'active' === $this->config->getAppValue($this->appName, $hook);
            if (true === $active) {
                $this->root->listen('\OC\Files', $hook, ${$hook});
            }
        }
    }

    /**
     * @param Node $node
     */
    public function postWrite(Node $node) {
        $this->logService->log(sprintf('Datei geschrieben durch  %s', $this->userName),
            ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postCreate(Node $node) {
        $this->logService->log(sprintf('Datei erstellt durch  %s', $this->userName),
            ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postDelete(Node $node) {
        $this->logService->log(sprintf('Datei gelöscht durch  %s', $this->userName),
            ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postTouch(Node $node) {
        $this->logService->log(sprintf('Datei angesehen durch  %s', $this->userName),
            ['path' => $node->getPath()]);
    }

    /**
     * @param Node $source
     */
    public function postCopy(Node $source, Node $target) {
        $this->logService->log(sprintf('Datei  durch  %s von %s nach %s kopiert',
            $this->userName, $source->getName(), $target->getName()),
            [
                'path_old' => $source->getPath(),
                'path_new' => $target->getPath()
            ]);
    }

    /**
     * @param Node $source
     */
    public function postRename(Node $source, Node $target) {
        $this->logService->log(sprintf('Datei durch  %s von %s nach %s umbenannt', $this->userName,
            $source->getName(), $target->getName()),
            [
                'path_old' => $source->getPath(),
                'path_new' => $target->getPath()
            ]);
    }
}