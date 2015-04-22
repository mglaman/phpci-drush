# PHPCI-Drush
Drush plugin for PHPCI

## Usage


### Add to PHPCI

Add the package to your PHPCI's composer required projects.

````
composer require mglaman/phpci-drush
````

### Use in projects

````
    \mglaman\PhpciPlugins\DrushPlugin:
        command: "version"
    \mglaman\PhpciPlugins\DrushPlugin:
        command: "pm-enable"
        arguments: "ctools panels page_manager"
        options: "--yes"
````
