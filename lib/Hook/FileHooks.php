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
    private $logService;

    public function __construct($folder, $logService) {
        $this->folder = $folder;
        $this->logService = $logService;
    }

    public function register() {

        $callbackPostWrite = function (\OCP\Files\Node $node) {
            $this->logService->log('Datei geschrieben', ['path' => $node->getPath()]);
        };

        $callbackPostCreate = function (\OCP\Files\Node $node) {
            $this->logService->log('Datei erstellt', ['path' => $node->getPath()]);
        };

        $callbackPostDelete = function (\OCP\Files\Node $node) {
            $this->logService->log('Datei gelöscht', ['path' => $node->getPath()]);
        };
        $callbackPostTouch = function (\OCP\Files\Node $node) {

        };
        $callbackPostCopy = function (\OCP\Files\Node $node) {

        };
        $callbackPostRename = function (\OCP\Files\Node $node) {

        };


        // register listeners for file system events
        $this->folder->listen('\OCP\Files\Node', 'postWrite', $callbackPostWrite);
        $this->folder->listen('\OCP\Files\Node', 'postCreate', $callbackPostCreate);
        $this->folder->listen('\OCP\Files\Node', 'postDelete', $callbackPostDelete);
        $this->folder->listen('\OCP\Files\Node', 'postTouch', $callbackPostTouch);
        $this->folder->listen('\OCP\Files\Node', 'postCopy', $callbackPostCopy);
        $this->folder->listen('\OCP\Files\Node', 'postRename', $callbackPostRename);
    }
}