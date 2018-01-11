<?php
/**
 * Created by PhpStorm.
 * User: constantin
 * Date: 08.11.17
 * Time: 16:26
 */

namespace OCA\HyperLog\Hook;

use OCA\HyperLog\Service\LogService;
use OCP\Files\Node;

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

    public function __construct($root, $user, $logService, $config, $appName) {
        $this->root = $root;
        $this->user = $user;
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
        $this->logService->log(sprintf('Datei geschrieben durch User %s', $this->user->getUID()),
            ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postCreate(Node $node) {
        $this->logService->log(sprintf('Datei erstellt durch User %s', $this->user->getUID()),
            ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postDelete(Node $node) {
        $this->logService->log(sprintf('Datei geloescht durch User %s', $this->user->getUID()),
            ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postTouch(Node $node) {
        $this->logService->log(sprintf('Datei angesehen durch User %s', $this->user->getUID()),
            ['path' => $node->getPath()]);
    }

    /**
     * @param Node $source
     */
    public function postCopy(Node $source, Node $target) {
        $this->logService->log(sprintf('Datei  durch User %s von %s nach %s kopiert',
            $this->user->getUID(), $source->getName(), $target->getName()),
            [
                'path_old' => $source->getPath(),
                'path_new' => $target->getPath()
            ]);
    }

    /**
     * @param Node $source
     */
    public function postRename(Node $source, Node $target) {
        $this->logService->log(sprintf('Datei durch User %s von %s nach %s umbenannt', $this->user->getUID(),
            $source->getName(), $target->getName()),
            [
                'path_old' => $source->getPath(),
                'path_new' => $target->getPath()
            ]);
    }
}