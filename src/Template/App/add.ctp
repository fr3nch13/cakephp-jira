<?php
/**
 * The default form for submitting reports.
 *
 * It is setup based on my projects that use a boostrap/admin lte them that I wrote.
 * You don't have to use it, and infact you'll get an error if you don't have a Template/base.ctp page.
 *
 * This is an example of the issue submission form.
 * It generates the form fields based on the settings from the underlying form object.
 */

$this->extend('/base');

$title ?? __('Report');

$this->assign('page-title', __('Submit a {0}', [$title]));
$this->assign('page-subtitle', __(' '));
$this->start('page-content');
?>
<section class="page-content">
    <div class="config form">
        <div class="box">
            <div class="box-body">
                <?= $this->Form->create($form) ?>
                <fieldset>
                <?php
                $data = $form->getFormData();
                foreach ($data['fields'] as $field => $options) {
                    echo $this->Form->control($field, $options);
                }
                ?>
                </fieldset>
                <fieldset>
                    <?= $this->Form->button(__('Send {0}', [$title])) ?>
                </fieldset>
                <?= $this->Form->end() ?>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</section>
<?php $this->end('page-content'); ?>
