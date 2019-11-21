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
     * Thow a 500 when something is missing.
     * @var int
     */
    protected $_defaultCode = 500;

    /**
     * Constructor.
     *
     * Allows you to create exceptions that are treated as framework errors and disabled
     * when debug mode is off.
     *
     * @param string|array $message Either the string of the error message, or an array of attributes
     *   that are made available in the view, and sprintf()'d into Exception::$_messageTemplate
     * @param int|null $code The code of the error, is also the HTTP status code for the error.
     * @param \Exception|null $previous the previous exception.
     */
    public function __construct($message = '', $code = null, $previous = null)
    {
        $this->_messageTemplate = __('Seems that the config key `Jira.%s` is not set.');

        parent::__construct($message, $code, $previous);
    }
}