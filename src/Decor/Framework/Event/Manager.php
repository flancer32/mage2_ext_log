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
    protected $logger;

    public function __construct(
        \Flancer32\Logging\Fw\Logger\Event $logger
    ) {
        $this->logger = $logger;
    }

    public function beforeDispatch(
        \Magento\Framework\Event\Manager $subject,
        $eventName,
        array $data = []
    ) {
        /* TODO: switch logging in config */
        if(false) {
            $this->logger->debug($eventName);
        }
    }
}