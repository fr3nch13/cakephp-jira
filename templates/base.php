<?php
declare(strict_types=1);

$this->extend('/Content/base');

if (!$this->fetch('page-title')) {
    $this->assign('page-title', __('Base'));
}

if (!$this->fetch('page-subtitle')) {
    $this->assign('page-subtitle', __('Base'));
}

if (!$this->fetch('page-content')) :
    $this->start('page-content');
    ?>
Base template
    <?php
    $this->end('page-content');
endif;
