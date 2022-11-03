<?php

declare(strict_types=1);

/**
 * Content Base Template.
 * The below referenced Plugin is internal to some of my projects.
 * I have it referenced here until I find another way ro reference it.
 *
 * @var \App\View\AppView $this
 */

use Cake\Core\Plugin;

if (Plugin::isLoaded('Sis/AdminLTE')) {
    $this->extend('Sis/Core./Content/generic');
}

if (!$this->fetch('page-title')) {
    $this->assign('page-title', __('Content/Base'));
}
if (!$this->fetch('page-subtitle')) {
    $this->assign('page-subtitle', __('Content/Base'));
}
if (!$this->fetch('page-actions')) :
    $this->start('page-actions');
    $this->end(); //page-actions
endif;
if (!$this->fetch('page-content')) :
    $this->start('page-content');
    ?>
Base template
    <?php
    $this->end(); //page-content
endif;

if (!$this->fetch('content')) :
    $this->start('content');
    echo $this->fetch('page-content');
    $this->end(); //page-content
endif;
