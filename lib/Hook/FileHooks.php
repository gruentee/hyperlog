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

    public function __construct($root, $logService) {
        $this->root = $root;
        $this->logService = $logService;
    }

    public function register() {
        $reference = $this;

        $callbackPostWrite = function (Node $node) use ($reference) {
            $reference->postWrite($node);
        };
        $callbackPostCreate = function (Node $node) use ($reference) {
            $reference->postCreate($node);
        };
        $callbackPostDelete = function (Node $node) use ($reference) {
            $reference->postDelete($node);
        };
        $callbackPostTouch = function (Node $node) use ($reference) {
            $reference->postTouch($node);
        };
        $callbackPostCopy = function (Node $source, Node $target) use ($reference) {
            $reference->postCopy($source, $target);
        };
        $callbackPostRename = function (Node $source, Node $target) use ($reference) {
            $reference->postRename($source, $target);
        };

        // register listeners for file system events
        $this->root->listen('\OC\Files', 'postWrite', $callbackPostWrite);
        $this->root->listen('\OC\Files', 'postCreate', $callbackPostCreate);
        $this->root->listen('\OC\Files', 'postDelete', $callbackPostDelete);
        $this->root->listen('\OC\Files', 'postTouch', $callbackPostTouch);
        $this->root->listen('\OC\Files', 'postCopy', $callbackPostCopy);
        $this->root->listen('\OC\Files', 'postRename', $callbackPostRename);
    }

    /**
     * @param Node $node
     */
    public function postWrite(Node $node) {
        $this->logService->log('Datei geschrieben', ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postCreate(Node $node) {
        $this->logService->log('Datei erstellt', ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postDelete(Node $node) {
        $this->logService->log('Datei geloescht', ['path' => $node->getPath()]);
    }

    /**
     * @param Node $node
     */
    public function postTouch(Node $node) {
        $this->logService->log('Datei angesehen', ['path' => $node->getPath()]);
    }

    /**
     * @param Node $source
     */
    public function postCopy(Node $source, Node $target) {
        $this->logService->log('Datei ' . $source->getName() . ' nach ' . $target->getName() . ' kopiert',
            [
                'path_old' => $source->getPath(),
                'path_new' => $target->getPath()
            ]);
    }

    /**
     * @param Node $source
     */
    public function postRename(Node $source, Node $target) {
        $this->logService->log('Datei ' . $source->getName() . ' nach ' . $target->getName() . ' umbenannt',
            [
                'path_old' => $source->getPath(),
                'path_new' => $target->getPath()
            ]);
    }
}