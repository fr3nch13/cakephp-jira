<?php
declare(strict_types=1);

/**
 * MissingIssueFieldException
 */

namespace Fr3nch13\Jira\Exception;

/**
 * Missing Issue Exception
 *
 * Throw when a Project's Issue can't be found.
 */
class MissingIssueFieldException extends JiraBaseException
{
    /**
     * @var int Throw a 404 when a field is missing.
     */
    protected $_defaultCode = 404;

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
        $this->_messageTemplate = __('Missing the issue field: %s');

        parent::__construct($message, $code, $previous);
    }
}
