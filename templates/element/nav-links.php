<?php
declare(strict_types=1);
/**
 * The template that can be used to place the links withing a bootstrap menu.
 */
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
                <a href="<?= $this->Url->build(['action' => 'add', 'controller' => 'Bugs', 'plugin' => 'Fr3nch13/Jira', 'prefix' => false]); ?>" class="btn btn-default btn-flat">Bug</a>
            </div>
            <div class="pull-right">
                <a href="<?= $this->Url->build(['action' => 'add', 'controller' => 'FeatureRequests', 'plugin' => 'Fr3nch13/Jira', 'prefix' => false]); ?>" class="btn btn-default btn-flat">Feature</a>
            </div>
            <div style="clear: both;"></div>
        </li>
        <li class="jira-footer">
        </li>
    </ul>
</li>
