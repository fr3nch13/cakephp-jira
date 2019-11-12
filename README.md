# CakePHP Jira Plugin

This is a CakePHP 3.x plugin to interact with your Jira Server.

Note: As of the initial version of this plugin, it is read-only,
and only supports pulling in info from a single project, and all of it's issues.

Yes, I know there aren't any unit tests yet. If people other than me start using it, I'll add unit tests... Unless you want to.

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
