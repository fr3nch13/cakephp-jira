<?php
$this->extend('/Content/base');

if (!$this->fetch('page-title')) {
    $this->assign('page-title', __('Base'));
}

if (!$this->fetch('page-subtitle')) {
    $this->assign('page-subtitle', __('Base'));
}

$this->append('page-breadcrumb');
?>
<li><?= $this->Html->link(__('Dashboard'), ['action' => 'index', 'controller' => 'App']); ?></li>

<?php
$this->fetch('page-breadcrumb');
$this->end('page-breadcrumb');

if (!$this->fetch('main-sidebar-menu')) :
    $this->start('main-sidebar-menu'); ?>
  <!-- sidebar menu: : style can be found in sidebar.less -->
    <?= $this->element('aside/sidebar-menu'); ?>
    <?php $this->end('main-sidebar-menu');
endif;

if (!$this->fetch('page-content')) :
    $this->start('page-content');
    ?>
Base template
    <?php
    $this->end('page-content');
endif;
