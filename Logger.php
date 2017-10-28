<?php
/**
 * Wrapper for default Magento 2 logger or for Cascaded Monolog logger.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Logging;


class Logger
    implements \Psr\Log\LoggerInterface
{
    /** Default configuration file for the logger */
    const DEF_CONFG_FILE = 'var/log/logging.yaml';
    /** Logger name in config: 'var/log/logging.yaml' */
    const DEF_LOGGER_NAME = 'main';
    /**
     * Logger (default Magento 2 logger or Cascaded Monolog).
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct(
        \Magento\Framework\Logger\Monolog $monolog,
        $configFile = null,
        $loggerName = null
    )
    {
        /* validate input parameters */
        $config = is_null($configFile) ? static::DEF_CONFG_FILE : $configFile;
        $name = is_null($loggerName) ? static::DEF_LOGGER_NAME : $loggerName;

        /* try to init cascaded loggers */
        try {
            $fs = new \Symfony\Component\Filesystem\Filesystem();
            if ($fs->isAbsolutePath($config)) {
                $fileName = $config;
            } else {
                $fileName = BP . '/' . $config;
            }
            $realPath = realpath($fileName);
            if ($realPath) {
                \Cascade\Cascade::fileConfig($realPath);
                $this->logger = \Cascade\Cascade::getLogger($name);
            } else {
                $this->logger = $monolog;
                $err = "Cannot open logging configuration file '$fileName'. Default Magento logger is used.";
                $this->warning($err);
            }
        } catch (\Exception $e) {
            if (is_null($this->logger)) $this->logger = $monolog;
            $this->warning($e->getMessage());
        }
    }

    public function alert($message, array $context = [])
    {
        $this->logger->alert($message, $context);
    }

    public function critical($message, array $context = [])
    {
        $this->logger->critical($message, $context);
    }

    public function debug($message, array $context = [])
    {
        $this->logger->debug($message, $context);
    }

    public function emergency($message, array $context = [])
    {
        $this->logger->emergency($message, $context);
    }

    public function error($message, array $context = [])
    {
        $this->logger->error($message, $context);
    }

    public function info($message, array $context = [])
    {
        $this->logger->info($message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $context);
    }

    public function notice($message, array $context = [])
    {
        $this->logger->notice($message, $context);
    }

    public function warning($message, array $context = [])
    {
        $this->logger->warning($message, $context);
    }
}