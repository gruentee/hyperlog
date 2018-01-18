<?php

namespace OCA\HyperLog\Hook;

use OCA\HyperLog\Service\LogService;
use OCP\IRequest;

class DownloadHooks {
    private $request;
    private $logService;
    private $currentUser;

    public function __construct(IRequest $request, $currentUser, LogService $logService) {
        $this->request = $request;
        $this->currentUser = $currentUser;
        $this->logService = $logService;

    }

    public function logDownload() {
        $http_verb = $this->request->getMethod();

        $this->logService->log("is download request: " . ($this->isDownloadRequest($this->request) ? "true" : "false"));
        $this->logService->log((string)$this->request);
        if ($http_verb == 'GET') {
            if (true === $this->isDownloadRequest($this->request)) {
                $this->logService->log(sprintf('Datei %s durch User %s heruntergeladen', $this->request->getRawPathInfo(),
                    $this->currentUser->getUID()),
                    ['requestId' => $this->request->getId()]
                );
            }
        }
    }

    /**
     * @param IRequest $request
     * @return bool
     */
    private function isDownloadRequest(IRequest $request) {
        // check Content-Disposition header
        // check for param `downloadStartSecret`
        $this->logService->log("response header content-disposition: " . $request->getHeader('Content-Disposition'));
        return 'attachment' === substr($request->getHeader('Content-Disposition'), 0, 10);
        //&& (null !== $request->getParam('downloadStartSecret'));
    }
}