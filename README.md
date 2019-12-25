# CakePHP Jira Plugin

[![Build Status](https://travis-ci.com/fr3nch13/cakephp-jira.svg?branch=1.x)](https://travis-ci.com/fr3nch13/cakephp-jira)
[![Total Downloads](https://img.shields.io/packagist/dt/fr3nch13/cakephp-jira.svg?style=flat-square)](https://packagist.org/packages/fr3nch13/cakephp-jira)
[![Latest Stable Version](https://img.shields.io/packagist/v/fr3nch13/cakephp-jira.svg?style=flat-square)](https://packagist.org/packages/fr3nch13/cakephp-jira)
[![Coverage Status](https://img.shields.io/codecov/c/github/fr3nch13/cakephp-jira.svg?style=flat-square)](https://codecov.io/github/fr3nch13/cakephp-jira)

[![Build Status](https://scrutinizer-ci.com/g/fr3nch13/cakephp-jira/badges/build.png?b=1.x)](https://scrutinizer-ci.com/g/fr3nch13/cakephp-jira/build-status/1.x)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fr3nch13/cakephp-jira/badges/quality-score.png?b=1.x)](https://scrutinizer-ci.com/g/fr3nch13/cakephp-jira/?branch=1.x)
[![Code Coverage](https://scrutinizer-ci.com/g/fr3nch13/cakephp-jira/badges/coverage.png?b=1.x)](https://scrutinizer-ci.com/g/fr3nch13/cakephp-jira/?branch=1.x)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/fr3nch13/cakephp-jira/badges/code-intelligence.svg?b=1.x)](https://scrutinizer-ci.com/code-intelligence)

This is a CakePHP 3.x plugin to interact with your Jira Server.

This makes heavy use of [lesstif/php-jira-rest-client's](https://github.com/lesstif/php-jira-rest-client) project as essentially a CakePHP specific wrapper around that project.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

Either run the following command (may vary on how you have composer installed):

```
composer require fr3nch13/cakephp-jira
```

Or add the below to your composer.json file:

```
{
    "require": {
        "fr3nch13/cakephp-jira": "1.*"
    }
}
```

Then run:
```
composer update
```

## Setup

In your `src/Application.php's bootstrap()` method, add the following:
```php
/**
 * Bootstrap function for browser-based access.
 *
 * @return void
 */
public function bootstrap()
{
    /**
     * Load stuff needed from the cakephp core.
     */
    parent::bootstrap();

    // .... other code here.

    /**
     * Load all of the plugins you need.
     */
    $this->addPlugin('Fr3nch13/Jira');

    // .... other code here.
}
```

Load the helper in your `src/View/AppView.php's initialize()` method:
```php
    /**
     * Initialize method
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        // .... other code here.

        if (Plugin::isLoaded('Fr3nch13/Jira')) {
            $this->loadHelper('Jira', ['className' => 'Fr3nch13/Jira.Jira']);
        }

        // .... other code here.
    }
```

This plugin makes use of [josegonzalez/dotenv](https://github.com/josegonzalez/php-dotenv). If you're using his extension, than put the below in your `config/.env` file:
```bash
##### Jira Settings. (if the JIRA plugin is active.)
export JIRA_SCHEMA=""
## name: Protocol
## desc: The protocol that the Jira server uses. Either http, or https
## default: https
## type: select
## options: {"http": "http", "https": "https"}
export JIRA_HOST=""
## name: Hostname
## desc: The full hostname to the Jira server
## default: jira.domain.com
## type: string
export JIRA_USERNAME=''
## name: Username
## desc: The username to use when authenticating with Jira.
## default: jirausername
## type: string
export JIRA_API_KEY=''
## name: API Key
## desc: The API Key to authenticate with Jira.
## default: jiraapikey
## type: string
export JIRA_PROJECT_KEY=''
## name: Project Key
## desc: The Key of the Project in Jira that represents this app.
## default: jiraprojectkey
## type: string
```
This plugin's `src/Plugin.php's bootstrap()` will automatically read these into Cakephp's Configure static class.

If you're not using `dotenv`, then put this in your `config/app.php` file:
```php
/// ... previous settings.
    'Jira' => [
        'schema' => 'https',
        'host' => 'jira.domain.com',
        'username' => 'your-jira-username',
        'apiKey' => 'you-jira-username-or-api-key',
        'projectKey' => 'your-project-key', // The code before the issue id ex: PROJECT-81, it would be PROJECT.
    ]
/// ... more settings.
```

## Usage

The primary entry point is the Jira Helper.

I have also added the ability to send Issues to your Jira server.

The 2 default/preconfigured Issues are Bugs and Feature Requests, but you can configure your own as well.

To create your own Issue setup, see these as examples:
- [`Fr3nch\Jira\Controller\TestsController`](blob/1.x/src/Controller/TestsController.php)
- [`Fr3nch\Jira\Form\TestForm`](blob/1.x/src/Form/TestForm.php) <-- How you define another Issue type. see the `__construct()` method.
- [`Template/Tests/add.ctp`](blob/1.x/src/Template/Tests/add.ctp)
- [`Template/Tests/thankyou.ctp`](blob/1.x/src/Template/Tests/thankyou.ctp)

In my particular instance, I have the links as part of a dropdown menu in my apps' header. My apps use the AdmilLte/bootstrap template/frontend, so if you want, you can include the element existing here like so:
```php
<?php if (Plugin::isLoaded('Fr3nch13/Jira')) : ?>
<?= $this->element('Fr3nch13/Jira.nav-links') ?>
<?php endif; //Plugin::isLoaded('Fr3nch13/Jira') ?>
```
In case you want to see how I'm creating the link to the pages, see the [`src/Template/Element/nav-links.ctp`](blob/1.x/src/Template/Element/nav-links.ctp) file.

If you want to overwrite the plugin templates, do so like you're supposed according to the [CakePHP Documentation](https://book.cakephp.org/3/en/plugins.html#overriding-plugin-templates-from-inside-your-application).

## Version compatibility

The major versions are locked to the major versions of CakePHP.
- Jira 1.x is locked to CakePHP ^3.8
- Jira 2.x is locked to CakePHP ^4.0

## Contributing

Rules are simple:

- New feature needs tests.
- All tests must pass.
    ```bash
    composer ci
    ```
- 1 feature per PR

We would be happy to merge your feature then.

## Notes
- I've inlcuded the composer.lock file, and if you're forking/pull requesting, you should use it/update it as well. This way our environment is as close as possible. This helps in debugging/replicating an issue.
