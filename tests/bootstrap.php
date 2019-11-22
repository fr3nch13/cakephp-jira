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
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__));
define('APP_DIR', 'src');

define('APP', rtrim(sys_get_temp_dir(), DS) . DS . APP_DIR . DS);
if (!is_dir(APP)) {
    mkdir(APP, 0770, true);
}

define('TMP', ROOT . DS . 'tmp' . DS);
if (!is_dir(TMP)) {
    mkdir(TMP, 0770, true);
}
define('CONFIG', ROOT . DS . 'config' . DS);

define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);

define('CAKE_CORE_INCLUDE_PATH', ROOT . '/vendor/cakephp/cakephp');
define('CORE_PATH', CAKE_CORE_INCLUDE_PATH . DS);
define('CAKE', CORE_PATH . APP_DIR . DS);

require dirname(__DIR__) . '/vendor/autoload.php';
require CORE_PATH . 'config/bootstrap.php';

Configure::write('App', [
    'namespace' => 'App',
    'paths' => [
        'templates' => [ROOT . DS . 'tests' . DS . 'test_app' . DS . 'src' . DS . 'Template' . DS],
    ]
]);

Configure::write('debug', true);

Cache::setConfig([
    '_cake_core_' => [
        'engine' => 'File',
        'prefix' => 'cake_core_',
        'serialize' => true
    ],
    '_cake_model_' => [
        'engine' => 'File',
        'prefix' => 'cake_model_',
        'serialize' => true
    ]
]);

// Ensure default test connection is defined
if (!getenv('db_dsn')) {
    putenv('db_dsn=sqlite:///:memory:');
}

ConnectionManager::setConfig('test', ['url' => getenv('db_dsn')]);

Configure::write('Session', [
    'defaults' => 'php'
]);

Log::setConfig([
    'debug' => [
        'engine' => 'Cake\Log\Engine\FileLog',
        'levels' => ['notice', 'info', 'debug'],
        'file' => 'debug',
        'path' => LOGS,
    ],
    'error' => [
        'engine' => 'Cake\Log\Engine\FileLog',
        'levels' => ['warning', 'error', 'critical', 'alert', 'emergency'],
        'file' => 'error',
        'path' => LOGS,
    ]
]);

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
