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
    /** @var bool cache for configuration settings (common for all store views, websites) */
    protected $enabled = null;
    /** @var \Flancer32\Logging\Helper\Config */
    protected $hlpConfig;
    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    public function __construct(
        \Flancer32\Logging\Fw\Logger\Event $logger,
        \Flancer32\Logging\Helper\Config $hlpConfig
    ) {
        $this->logger = $logger;
        $this->hlpConfig = $hlpConfig;
    }

    /**
     * @param \Magento\Framework\Event\Manager $subject
     * @param $eventName
     * @param array $data
     * @return null no modifications for input arguments
     */
    public function beforeDispatch(
        \Magento\Framework\Event\Manager $subject,
        $eventName,
        array $data = []
    ) {
        /* $name is calculated twice to speed up calculations when logging is disabled */
        if ($this->enabled === false) {
            /* do nothing */
        } elseif ($this->enabled === true) {
            $name = is_string($eventName) ? $eventName : 'event name is not string';
            $keys = is_array($data) ? implode(',', array_keys($data)) : 'event data is not array';
            $msg = "$name: [$keys]";
            $this->logger->debug($msg);
        } else {
            /* 'core_collection_abstract_load_before' event is generated on store configuration loading, skip it */
            $name = is_string($eventName) ? $eventName : 'event name is not string';
            if (
                ($name != 'core_collection_abstract_load_before') &&
                ($name != 'core_collection_abstract_load_after')
            ) {
                $this->setEnabled();
                if ($this->enabled) {
                    /* log the first event if logging enabled */
                    $keys = is_array($data) ? implode(',', array_keys($data)) : 'event data is not array';
                    $msg = "$name: [$keys]";
                    $this->logger->debug($msg);
                }
            }
        }
    }

    protected function setEnabled()
    {
        if (is_null($this->enabled)) {
            $this->enabled = $this->hlpConfig->getEventsEnabled();
        }
    }
}