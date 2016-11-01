<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Logging\Decor\Framework\Event;

/**
 * Log events.
 */
class Manager
{
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    public function beforeDispatch(
        \Magento\Framework\Event\Manager $subject,
        $eventName,
        array $data = []
    ) {
//        $this->_logger->debug($eventName);
    }
}