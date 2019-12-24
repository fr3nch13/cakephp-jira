<?php
declare(strict_types=1);

/**
 * MissingAllowedTypeException
 */

namespace Fr3nch13\Jira\Exception;

use Cake\Core\Exception\Exception as BaseException;

/**
 * Missing Allowed Type Exception
 *
 * Throw when the JiraProject can't find a defined allowed type.
 */
class MissingAllowedTypeException extends BaseException
{
    /**
     * Throw a 404 when allowed type is missing.
     * @var int
     */
    protected $_defaultCode = 404;

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
        $this->_messageTemplate = __('Unknown Allowed Type: %s');

        if (is_string($message)) {
            $message = [0 => $message];
        }

        parent::__construct($message, $code, $previous);
    }
}
