<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Logging\Decor\Webapi\Controller;

/**
 * Log API paths processing.
 *
 * '/rest/russian_ru/V1/carts/mine/shipping-information' => '/V1/carts/mine/shipping-information'
 */
class PathProcessor
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
    ) {
        $this->logger = $logger;
        $this->hlpConfig = $hlpConfig;
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
        if ($this->isEnabled()) {
            $msg = "Path processing: '$pathInfo' => '$result'";
            $this->logger->debug($msg);
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