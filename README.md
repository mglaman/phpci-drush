# PHPCI-Drush
Drush plugin for PHPCI

## Usage


### Add to PHPCI

Add the package to your PHPCI's composer required projects.

````
composer require mglaman/phpci-drush
````

### Use in projects

Output the current Drush version.
````
    \mglaman\PhpciPlugins\DrushPlugin:
        command: "version"
````

Enable specific modules.
````
    \mglaman\PhpciPlugins\DrushPlugin:
        command: "pm-enable"
        arguments: 
            - "ctools"
            - "panels"
            - "page_manager"
        options: 
            - "yes"
````
Run a makefile.
````
    \mglaman\PhpciPlugins\DrushPlugin:
        command: "make"
        arguments:
            - "drupal-org.make.yml"
        options:
            - "verbose"
            - "no-cache"
            - "no-core"
            - "contrib-destination=."
            - "yes"
````
