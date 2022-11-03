<?php
declare(strict_types=1);

/**
 * Composer Installer Class
 */

namespace App\Console;

if (!defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'r'));
}

/**
 * Provides installation hooks for when this application is installed via
 * composer. Customize this class to suit your needs.
 */

class Installer
{
    /**
     * An array of directories to be made writable
     */
    public const WRITABLE_DIRS = [
        'logs',
        'tmp',
        'tmp/cache',
        'tmp/cache/models',
        'tmp/cache/persistent',
        'tmp/cache/views',
        'tmp/sessions',
        'tmp/tests',
    ];

    /**
     * Run post composer install methods
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @return void
     */
    public static function postInstall(\Composer\Script\Event $event): void
    {
        $io = $event->getIO();
        $io->write('Running App\Console\Installer\postInstall');
        $output = [];
        exec('pwd', $output);
        $rootDir = $output[0];
        $io->write('Root Dir:' . $rootDir);
        static::createAppConfig($rootDir, $io);
        static::createWritableDirectories($rootDir, $io);
        static::setFolderPermissions($rootDir, $io);
        static::setSecuritySalt($rootDir, $io);
    }

    /**
     * Run post composer update methods
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @return void
     */
    public static function postUpdate(\Composer\Script\Event $event): void
    {
        $io = $event->getIO();
        $io->write('Running App\Console\Installer\postUpdate');
        $output = [];
        exec('pwd', $output);
        $rootDir = $output[0];
        $io->write('Root Dir:' . $rootDir);
        static::createAppConfig($rootDir, $io);
        static::createWritableDirectories($rootDir, $io);
        static::setFolderPermissions($rootDir, $io);
        static::setSecuritySalt($rootDir, $io);
    }

    /**
     * Create the config/app.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createAppConfig(string $dir, \Composer\IO\IOInterface $io): void
    {
        $io->write('Running App\Console\BaseInstaller\createAppConfig');
        $appConfig = $dir . '/config/app.php';
        $defaultConfig = $dir . '/config/app.default.php';
        if (!file_exists($appConfig)) {
            $io->write('Creating `' . $appConfig . '` file');
            copy($defaultConfig, $appConfig);
            $io->write('Created `' . $appConfig . '` file');
        }
    }

    /**
     * Create the `logs` and `tmp` directories.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createWritableDirectories(string $dir, \Composer\IO\IOInterface $io): void
    {
        $io->write('Running App\Console\BaseInstaller\createWritableDirectories');
        foreach (static::WRITABLE_DIRS as $path) {
            $path = $dir . '/' . $path;
            if (!file_exists($path)) {
                $io->write('Creating `' . $path . '` directory');
                mkdir($path);
                $io->write('Created `' . $path . '` directory');
            }
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setFolderPermissions(string $dir, \Composer\IO\IOInterface $io): void
    {
        $io->write('Running App\Console\BaseInstaller\setFolderPermissions');
        // Change the permissions on a path and output the results.
        $changePerms = function ($path, $perms, $io) {
            // Get permission bits from stat(2) result.
            $currentPerms = fileperms($path) & 0770;
            if (($currentPerms & $perms) == $perms) {
                return;
            }
            $io->write('Setting permissions on ' . $path);
            $res = chmod($path, $currentPerms | $perms);
            if ($res) {
                $io->write('Permissions set on ' . $path);
            } else {
                $io->write('Failed to set permissions on ' . $path);
            }
        };

        $walker = function ($dir, $perms, $io) use (&$walker, $changePerms) {
            $files = scandir($dir);
            if (!$files) {
                $files = [];
            }
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $dir . '/' . $file;
                if (!is_dir($path)) {
                    continue;
                }
                $changePerms($path, $perms, $io);
                $walker($path, $perms, $io);
            }
        };

        $worldWritable = bindec('0000000111');
        $walker($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/logs', $worldWritable, $io);
    }

    /**
     * Set the security.salt value in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setSecuritySalt(string $dir, \Composer\IO\IOInterface $io): void
    {
        $io->write('Running App\Console\BaseInstaller\setSecuritySalt');
        $newKey = hash('sha256', \Cake\Utility\Security::randomBytes(64));
        static::setSecuritySaltInFile($dir, $io, $newKey, 'app.php');
    }

    /**
     * Set the security.salt value in a given file
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @param string $newKey key to set in the file
     * @param string $file A path to a file relative to the application's root
     * @return void
     */
    public static function setSecuritySaltInFile(
        string $dir,
        \Composer\IO\IOInterface $io,
        string $newKey,
        string $file
    ): void {
        $io->write('Running App\Console\BaseInstaller\setSecuritySaltInFile');
        $config = $dir . '/config/' . $file;
        $content = '';
        $count = 0;
        if (is_file($config)) {
            /** @var string $content */
            $content = file_get_contents($config);
            if (!$content) {
                $content = '';
            }
            $content = str_replace('__SALT__', $newKey, $content, $count);
        }
        if ($count == 0) {
            $io->write('No Security.salt placeholder to replace.');

            return;
        }
        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated Security.salt value in config/' . $file);

            return;
        }
        $io->write('Unable to update Security.salt value.');
    }

    /**
     * Set the APP_NAME value in a given file
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @param string $appName app name to set in the file
     * @param string $file A path to a file relative to the application's root
     * @return void
     */
    public static function setAppNameInFile(
        string $dir,
        \Composer\IO\IOInterface $io,
        string $appName,
        string $file
    ): void {
        $io->write('Running App\Console\BaseInstaller\setAppNameInFile');
        $config = $dir . '/config/' . $file;
        $content = '';
        $count = 0;
        if (is_file($config)) {
            /** @var string $content */
            $content = file_get_contents($config);
            if (!$content) {
                $content = '';
            }
            $content = str_replace('__APP_NAME__', $appName, $content, $count);
        }
        if ($count == 0) {
            $io->write('No __APP_NAME__ placeholder to replace.');

            return;
        }
        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated __APP_NAME__ value in config/' . $file);

            return;
        }
        $io->write('Unable to update __APP_NAME__ value.');
    }
}
