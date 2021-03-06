<?php
/**
 * User: Alex Gusev <alex@flancer64.com>
 */

namespace Flancer32\Logging\Logger;

/**
 * Decorator for events logger.
 */
class Event
    extends \Flancer32\Logging\Logger
{
    /** Logger name in config (see parent::DEF_CONFG_FILE) */
    const DEF_LOGGER_NAME = 'events';

}