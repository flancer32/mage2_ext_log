<?php
/**
 * Magento2-module registration.
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    \Flancer32\Logging\Config::MODULE,
    __DIR__
);