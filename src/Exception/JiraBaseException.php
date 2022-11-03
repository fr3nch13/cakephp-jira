<?php
declare(strict_types=1);

/**
 * Exception
 */

namespace Fr3nch13\Jira\Exception;

use Cake\Core\Exception\CakeException;

/**
 * Issue Submission Exception
 *
 * The generic Jira specific exception.
 */
class JiraBaseException extends CakeException
{
    /**
     * @var int Throw a 500 when something goes wrong.
     */
    protected $_defaultCode = 500;

    /**
     * Constructor.
     *
     * Allows you to create exceptions that are treated as framework errors and disabled
     * when debug mode is off.
     *
     * @param string|array<int, string> $message Either the string of the error message, or an array of attributes
     *   that are made available in the view, and sprintf()'d into Exception::$_messageTemplate
     * @param int|null $code The code of the error, is also the HTTP status code for the error.
     * @param \Exception|null $previous the previous exception.
     */
    public function __construct($message = '', $code = null, $previous = null)
    {
        if (!$this->_messageTemplate) {
            $this->_messageTemplate = __('Jira Error(s): %s');
        }
        
        if (is_string($message)) {
            $message = [0 => $message];
        }

        parent::__construct($message, $code, $previous);
    }
}
