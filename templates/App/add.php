<?php
declare(strict_types=1);
/**
 * The default form for submitting reports.
 *
 * It is setup based on my projects that use a boostrap/AdminLte theme that I wrote.
 * You don't have to use it, and infact you'll get an error if you don't have a Template/base.ctp page.
 * To see an example of the `/base.ctp` file, see: `Template/base-example.ctp` file.
 *
 *
 * This is an example of the issue submission form.
 * It generates the form fields based on the settings from the underlying form object.
 */

$this->extend('Fr3nch13/Jira./base');

$title = isset($title) ? $title : __('Report');

$this->assign('page-title', __('Submit a {0}', [$title]));
$this->assign('page-subtitle', __(' '));
$this->start('page-content');
?>
<section class="page-content">
    <div class="form">
        <?php
        /*
         * The src/Form/AppForm::_execute() will take any submission errors
         * from the src/Lib/JiraProject.php, and place them in the 'jira' key of the From errors like how the validator does.
         * This way I can display them here, instead under a specific field in the form below.
         */
        $errors = $form->getErrors();
        // display the jira errors.
        if (isset($errors['jira']) && count($errors['jira'])) : ?>
        <div class="box error">
            <div class="box-header with-border">
                <h3 class="box-title"><?= __('Errors') ?></h3>
            </div>
            <div class="box-body">
                <ul>
                    <?php foreach ($errors['jira'] as $jiraError) : ?>
                        <li><?= $jiraError ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-body">
                <?= $this->Form->create($form) ?>
                <fieldset>
                <?php
                /*
                 * This gets the fields defined in (as an example) src/Form/TestForm.php, if they're defined in your form.
                 * Otherwise, for Bugs and Feature Requests (the defaults), They're defined in src/Lib/JiraProject.php
                 * If you want to modify the default settings, set the $this->settings like in the src/Form/TestForm.php.
                 */
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
