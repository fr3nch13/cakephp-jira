<?php
/**
 * MissingIssueException
 */

namespace Fr3nch13\Jira\Exception;

use Fr3nch13\Jira\Exception\Exception;

/**
 * Missing Issue Exception
 *
 * Throw when a Project's Issue can't be found.
 */
class MissingIssueException extends Exception
{
    /**
     * Message template.
     */
    protected $_messageTemplate = __('Unable to find the issue: %s');

    /**
     * Thow a 404 when something is missing.
     */
    protected $_defaultCode = 404;
}
