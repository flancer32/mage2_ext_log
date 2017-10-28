<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Logging\Helper;

/**
 * Helper to get configuration parameters related to the module.
 * @SuppressWarnings(PHPMD.BooleanGetMethodName)
 */
class Config
{
    /** @var \Magento\Framework\App\Config\ScopeConfigInterface */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Events logging activity.
     *
     * @return bool
     */
    public function getEventsEnabled()
    {
        $result = $this->scopeConfig->getValue('dev/flancer32_log/enabled_events');
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        return $result;
    }

    /**
     * Web API logging activity.
     *
     * @return bool
     */
    public function getWebApiEnabled()
    {
        $result = $this->scopeConfig->getValue('dev/flancer32_log/enabled_webapi');
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        return $result;
    }
}