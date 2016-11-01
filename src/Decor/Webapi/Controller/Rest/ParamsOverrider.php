<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */
namespace Flancer32\Logging\Decor\Webapi\Controller\Rest;

class ParamsOverrider
{
    /** @var \Psr\Log\LoggerInterface */
    protected $_logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_logger = $logger;
    }

    public function afterOverride($subject, $result)
    {
        $json = json_encode($result);
        $this->_logger->debug("Request JSON: ".$json);
        return $result;
    }
}