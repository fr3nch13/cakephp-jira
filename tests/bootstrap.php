<?php
declare(strict_types=1);

/**
 * Test suite bootstrap.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */

putenv('JIRA_SCHEMA=https');
putenv('JIRA_HOST=jira.example.com');
putenv('JIRA_USERNAME=testusername');
putenv('JIRA_API_KEY=testapikey');
putenv('JIRA_PROJECT_KEY=TEST');

////// Ensure we can setup an environment for the Test Application instance.
$root = dirname(__DIR__);
chdir($root);
require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';
