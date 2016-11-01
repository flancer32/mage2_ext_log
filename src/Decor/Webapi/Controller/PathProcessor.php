<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Logging\Decor\Webapi\Controller;

class PathProcessor
{
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    /**
     * Log API paths processing.
     *
     * @param \Magento\Webapi\Controller\PathProcessor $subject
     * @param callable $proceed
     * @param $pathInfo
     * @return string
     */
    public function aroundProcess(
        \Magento\Webapi\Controller\PathProcessor $subject,
        callable $proceed,
        $pathInfo
    ) {
        $result = $proceed($pathInfo);
        $msg = "Path processing: '$pathInfo' => '$result'";
        $this->_logger->debug($msg);
        return $result;
    }
}