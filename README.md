# CakePHP Jira Plugin

This is a CakePHP 3.x plugin to interact with your Jira Server.

Note: As of the initial version of this plugin, it is read-only,
and only supports pulling in info from a single project, it's versions, and all of it's issues.

This makes heavy use of [lesstif/php-jira-rest-client's](https://github.com/lesstif/php-jira-rest-client) project as essentially a CakePHP specific wrapper around that project. 

Yes, I know there aren't any unit tests yet. If people other than me start using it, I'll add unit tests... Unless you want to (I would be using phpunit like how CakePHP does it).

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

Some of the helper methods you can use in your templates. I say this incase I add more, forget to update this readme.

### getInfo()
Gets information about the Jira Project.

```php
$projectInfo = $this->Jira->getInfo();
```

### getVersions()
If you're using Versions in your Project, this returns the list of all versions.

```php
$projectInfo = $this->Jira->getVersions();
```

### getIssues()
Retrieves all of your Issues related to your Project, ordered by their key ex: `PROJECT-81`

```php
$projectInfo = $this->Jira->getIssues();
```

### getOpenIssues()
Retrieves all of your Issues related to your Project, that aren't marked as `Done`, ordered by their key ex: `PROJECT-81`

```php
$projectInfo = $this->Jira->getOpenIssues();
```

### getIssue($id)
Gets a specific Issue from your Project, by it's ID. ex issue id: `PROJECT-81`, just give the `81` part.M

```php
$projectInfo = $this->Jira->getIssue('81');
```
