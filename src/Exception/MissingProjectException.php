<?php
/**
 * MissingProjectException
 */

namespace Fr3nch13\Jira\Exception;

use Fr3nch13\Jira\Exception\Exception;

/**
 * Missing Project Exception
 *
 * Throw when the Project can't be found.
 */
class MissingProjectException extends Exception
{
    /**
     * Message template.
     */
    protected $_messageTemplate = __('Unable to find the project: %s');

    /**
     * Thow a 404 when something is missing.
     */
    protected $_defaultCode = 404;
}
