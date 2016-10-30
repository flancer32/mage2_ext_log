<?php
/**
 * Script to register M2-module
 *
 * User: Alex Gusev <alex@flancer64.com>
 */
Registrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    \Flancer32\Logging\Config::MODULE,
    __DIR__
);