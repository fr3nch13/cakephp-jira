<?php
/**
 * MissingConfigException
 */

namespace Fr3nch13\Jira\Exception;

use Fr3nch13\Jira\Exception\Exception;

/**
 * Missing Config Exception
 *
 * Throw when a config variable is missing.
 */
class MissingConfigException extends Exception
{
    /**
     * Message template.
     */
    protected $_messageTemplate = __('Seems that the config key `Jira.%s` is not set.');

    /**
     * Thow a 500 when something is missing.
     */
    protected $_defaultCode = 500;
}
