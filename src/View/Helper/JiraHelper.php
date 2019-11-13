<?php
/**
 * JiraHelper
 */

namespace Fr3nch13\Jira\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\View;
use Fr3nch13\Jira\Lib\JiraProject;

/**
 * Jira Helper
 *
 * Helper to write out stuff about your jira project.
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class JiraHelper extends Helper
{
    /**
     * Contains the loaded Jira Project object.
     *
     * @var \Fr3nch13\Jira\Lib\JiraProject|null
     */
    protected $JiraProject = null;

    /**
     * Initialize the helper
     *
     * @param \Cake\View\View $View The view object
     * @param array $config Helper config settings
     * @return void
     */
    public function __construct(View $View, array $config = [])
    {
        parent::__construct($View, $config);

        $this->JiraProject = new JiraProject();
    }

    /**
     * Get the information about the Jira Project
     *
     * @return object Object containing the information about your project.
     * @throws \Fr3nch13\Jira\Exception\MissingProjectException If the project can't be found.
     */
    public function getInfo()
    {
        return $this->JiraProject->getInfo();
    }

    /**
     * Gets a list of all versions within your project.
     *
     * @return \ArrayObject A list of version objects.
     */
    public function getVersions()
    {
        return $this->JiraProject->getVersions();
    }

    /**
     * Gets a list of all issues within your project.
     *
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getIssues()
    {
        return $this->JiraProject->getIssues();
    }

    /**
     * Gets a list of all open issues within your project.
     *
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getOpenIssues()
    {
        return $this->JiraProject->getOpenIssues();
    }

    /**
     * Gets info on a particular issue within your project.
     *
     * @param int $id The issue id. The integer part without the project key.
     * @return object the object that has the info of that issue.
     * @throws \Fr3nch13\Jira\Exception\MissingIssueException If the project's issue can't be found.
     */
    public function getIssue($id = null)
    {
        return $this->JiraProject->getIssue($id);
    }

    /**
     * Gets a list of all issues that are bugs within your project.
     *
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getBugs()
    {
        return $this->JiraProject->getBugs();
    }

    /**
     * Gets a list of all open issues that are bugs within your project.
     *
     * @return \JiraRestApi\Issue\IssueSearchResult|\JiraRestApi\Issue\IssueSearchResultV3 A list of issue objects.
     */
    public function getOpenBugs()
    {
        return $this->JiraProject->getOpenBugs();
    }
}
