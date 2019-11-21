<?php
/**
 * Test suite bootstrap.
 *
 * This function is used to find the location of CakePHP whether CakePHP
 * has been installed as a dependency of the plugin, or the plugin is itself
 * installed as a dependency of an application.
 */

$findRoot = function ($root) {
    do {
        $lastRoot = $root;
        $root = dirname($root);
        if (is_dir($root . '/vendor/cakephp/cakephp')) {
            return $root;
        }
    } while ($root !== $lastRoot);

    throw new Exception('Cannot find the root of the application, unable to run tests');
};
$root = $findRoot(__FILE__);
unset($findRoot);

chdir($root);

require $root . '/vendor/cakephp/cakephp/tests/bootstrap.php';

if (file_exists($root . '/config/bootstrap.php')) {
    require $root . '/config/bootstrap.php';
}

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}
if (!defined('APP_DIR')) {
    define('APP_DIR', 'src');
}
if (!defined('CONFIG')) {
    define('CONFIG', ROOT . DS . 'config' . DS);
}
if (!defined('CAKE_CORE_INCLUDE_PATH')) {
    define('CAKE_CORE_INCLUDE_PATH', ROOT . '/vendor/cakephp/cakephp');
}
if (!defined('CORE_PATH')) {
    define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
}
if (!defined('CAKE')) {
    define('CAKE', CORE_PATH . APP_DIR . DS);
}
define('PLUGIN_ROOT', $root);

putenv('JIRA_SCHEMA=https');
putenv('JIRA_HOST=jira.example.com');
putenv('JIRA_USERNAME=testusername');
putenv('JIRA_API_KEY=testapikey');
putenv('JIRA_PROJECT_KEY=TEST');

Cake\Core\Configure::write('debug', true);
$app = new \App\Application(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config');
$app->addPlugin('Fr3nch13/Jira');
$plugin = new \Fr3nch13\Jira\Plugin();
$plugin->bootstrap($app);
Cake\Core\Plugin::getCollection()->add(new Fr3nch13\Jira\Plugin());
