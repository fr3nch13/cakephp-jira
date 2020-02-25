<?php
/**
 * The template that can be used to place the links withing a bootstrap menu.
 *
 * @var \App\View\AppView $this
 */

use Cake\Routing\Router;
?>
<li class="dropdown jira jira-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-sm fa-code-branch"></i>
    </a>
    <ul class="dropdown-menu" role="menu">
        <!-- User image -->
        <li class="jira-header">
            <p><?= __('Submit a...') ?></p>
        </li>
        <li class="jira-body">
            <div class="pull-left">
                <a href="<?= $this->Url->build([
                    'action' => 'add',
                    'controller' => 'Bugs',
                    'plugin' => 'Fr3nch13/Jira',
                    'prefix' => false,
                    '?' => [
                        'referer' => 1,
                    ],
                ]); ?>" class="jira-link btn btn-default btn-flat">Bug</a>
            </div>
            <div class="pull-right">
                <a href="<?= $this->Url->build([
                    'action' => 'add',
                    'controller' => 'FeatureRequests',
                    'plugin' => 'Fr3nch13/Jira',
                    'prefix' => false,
                    '?' => [
                        'referer' => 1
                    ],
                ]); ?>" class="jira-link btn btn-default btn-flat">Feature</a>
            </div>
            <div style="clear: both;"></div>
        </li>
        <li class="jira-footer">
        </li>
    </ul>
</li>
<script type="text/javascript">
$(document).ready(function()
{
    /**
     * This updates the urls for the jira links so the
     * submitted issue has an accurate url being reported.
     */
    $(window).bind('locationchange', function()
    {
        $('.jira-menu .jira-body a.jira-link').each(function(e)
        {
            var $href = $(this).attr('href');
            console.log($href);
            $href = $href.replace(/\?referer\=.*/, '?referer=' + encodeURI(window.location.href));
            $(this).attr('href', $href);
        });
    });
});
</script>
