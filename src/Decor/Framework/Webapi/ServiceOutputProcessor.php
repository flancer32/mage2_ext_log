<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Logging\Decor\Framework\Webapi;


class ServiceOutputProcessor
{
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_logger = $logger;
    }

    /**
     * Log REST response data.
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
    ) {
        $result = $proceed($data, $serviceClassName, $serviceMethodName);
        try {
            $json = json_encode($result);
            $msg = "Response from service '$serviceClassName::$serviceMethodName()': ";
            $msg .= $json;
            $this->_logger->debug($msg);
        } catch (\Throwable $th) {
            /* do nothing and stealth exception */
        }
        return $result;
    }
}