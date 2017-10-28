<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Logging\Decor\Webapi\Controller\Rest;

/**
 * Log request JSON.
 */
class ParamsOverrider
{
    /** @var bool cache for configuration settings (common for all store views, websites) */
    protected $enabled = null;
    /** @var \Flancer32\Logging\Helper\Config */
    protected $hlpConfig;
    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    public function __construct(
        \Flancer32\Logging\Fw\Logger\WebApi $logger,
        \Flancer32\Logging\Helper\Config $hlpConfig
    ) {
        $this->logger = $logger;
        $this->hlpConfig = $hlpConfig;
    }

    /**
     * Log request JSON.
     *
     * @param $subject
     * @param $result
     * @return mixed
     */
    public function afterOverride($subject, $result)
    {
        if ($this->isEnabled()) {
            $json = json_encode($result);
            $this->logger->debug("Request JSON: " . $json);
        }
        return $result;
    }

    protected function isEnabled()
    {
        if (is_null($this->enabled)) {
            $this->enabled = $this->hlpConfig->getWebApiEnabled();
        }
        return $this->enabled;
    }
}