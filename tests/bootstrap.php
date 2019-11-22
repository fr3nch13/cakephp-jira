<?php
/**
 * Test suite bootstrap.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */

//

////// Ensure we can setup an environment for the Test Application instance.
$root = dirname(__DIR__);
chdir($root);
require_once $root . '/vendor/fr3nch13/cakephp-pta/tests/plugin_bootstrap.php';

//////

putenv('JIRA_SCHEMA=https');
putenv('JIRA_HOST=jira.example.com');
putenv('JIRA_USERNAME=testusername');
putenv('JIRA_API_KEY=testapikey');
putenv('JIRA_PROJECT_KEY=TEST');

$app = new App\Application(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config');
$app->addPlugin('Fr3nch13/Jira');
$plugin = new Fr3nch13\Jira\Plugin();
$plugin->bootstrap($app);
Cake\Core\Plugin::getCollection()->add(new Fr3nch13\Jira\Plugin());
