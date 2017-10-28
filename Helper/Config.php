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
    private $scopeConfig;
    /** @var \Magento\Framework\App\State */
    private $appState;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\State $appState
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->appState = $appState;
    }

    /**
     * Events logging activity.
     *
     * @return bool
     */
    public function getEventsEnabled()
    {
        $result = $this->scopeConfig->getValue('system/flancer32_log/enabled_events');
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        $result = $result && !$this->isInProductionMode();
        return $result;
    }

    /**
     * Web API logging activity.
     *
     * @return bool
     */
    public function getWebApiEnabled()
    {
        $result = $this->scopeConfig->getValue('system/flancer32_log/enabled_webapi');
        $result = filter_var($result, FILTER_VALIDATE_BOOLEAN);
        $result = $result && !$this->isInProductionMode();
        return $result;
    }

    private function isInProductionMode()
    {
        $mode = $this->appState->getMode();
        $result = ($mode == \Magento\Framework\App\State::MODE_PRODUCTION);
        return $result;
    }
}