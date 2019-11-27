<?php
/**
 * The default thank you page.
 *
 * It is setup based on my projects that use a boostrap/admin lte them that I wrote.
 * You don't have to use it, and infact you'll get an error if you don't have a Template/base.ctp page.
 */

$this->extend('/base');

$type ?? __('Report');

$this->assign('page-title', __('Thank You!'));
$this->assign('page-subtitle', __(' '));
$this->start('page-content');
?>
<section class="page-content">
    <div class="box">
        <div class="box-body">
            <h4><?= __('Thank you for submitting the {0}.', [$type]) ?></h4>
        </div>
    </div>
</section>
<?php $this->end('page-content'); ?>
