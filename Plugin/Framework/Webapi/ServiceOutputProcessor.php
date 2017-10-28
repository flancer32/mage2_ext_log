<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Logging\Plugin\Framework\Webapi;

/**
 * Log REST response data.
 */
class ServiceOutputProcessor
{
    /** @var bool cache for configuration settings (common for all store views, websites) */
    protected $enabled = null;
    /** @var \Flancer32\Logging\Helper\Config */
    protected $hlpConfig;
    /** @var \Psr\Log\LoggerInterface */
    protected $logger;

    public function __construct(
        \Flancer32\Logging\Logger\WebApi $logger,
        \Flancer32\Logging\Helper\Config $hlpConfig
    )
    {
        $this->logger = $logger;
        $this->hlpConfig = $hlpConfig;
    }

    /**
     * Log REST response data. 'Around' decoration is used to get service class & method names.
     *
     * @param \Magento\Framework\Webapi\ServiceOutputProcessor $subject
     * @param callable $proceed
     * @param mixed $data
     * @param string $serviceClassName
     * @param string $serviceMethodName
     * @return array
     */
    public function aroundProcess(
        \Magento\Framework\Webapi\ServiceOutputProcessor $subject,
        callable $proceed,
        $data,
        $serviceClassName,
        $serviceMethodName
    )
    {
        $result = $proceed($data, $serviceClassName, $serviceMethodName);
        if ($this->isEnabled()) {
            try {
                $json = json_encode($result);
                $msg = "Response from service '$serviceClassName::$serviceMethodName()': ";
                $msg .= $json;
                $this->logger->debug($msg);
            } catch (\Throwable $th) {
                /* do nothing and stealth exception */
            }
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