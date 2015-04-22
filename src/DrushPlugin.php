<?php

namespace mglaman\PhpciPlugins;

use PHPCI\Builder;
use PHPCI\Plugin;
use PHPCI\Helper\Lang;
use PHPCI\Model\Build;

/**
 * Drush Plugin - Provides access to Drush
 * @author  Matt Glaman <matt@bluehorndigital.com>
 * @package mglaman\PhpciPlugins
 */
class DrushPlugin implements Plugin
{
    protected $phpci;
    protected $build;
    protected $log;
    protected $command;
    protected $options;
    protected $arguments;

    /**
     * Standard Constructor
     *
     * $options['directory'] Output Directory. Default: %BUILDPATH%
     * $options['filename']  Phar Filename. Default: build.phar
     * $options['regexp']    Regular Expression Filename Capture. Default: /\.php$/
     * $options['stub']      Stub Content. No Default Value
     *
     * @param Builder $phpci
     * @param Build $build
     * @param array $options
     */
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci = $phpci;
        $this->build = $build;

        if (isset($options['executable'])) {
            $this->executable = $options['executable'];
        } else {
            $this->executable = $this->phpci->findBinary('drush');
        }

        if (isset($options['command'])) {
            $this->command = $options['command'];
        }
        if (isset($options['arguments'])) {
            $this->arguments = $this->formatArguments($options['arguments']);
        }
        if (isset($options['options'])) {
            $this->options = $this->formatOptions($options['options']);
        }
    }


    /**
     * Formats the arguments passed to Drush.
     *
     * Some Drush commands accept a single argument or multiple. This allows
     * us to define arguments as a single string or an array an format it.
     *
     * @param string|array $arguments
     *
     * @return string
     */
    protected function formatArguments($arguments)
    {
        if (is_array($arguments)) {
            return implode(' ', $arguments);
        } else {
            return $arguments;
        }
    }

    /**
     * Formats the array of options passed to Drush.
     *
     * @param array $options
     *
     * @return string
     */
    protected  function formatOptions(array $options)
    {
        $optionsString = '';
        foreach ($options as $option) {
            $optionsString .= '--' . $option . ' ';
        }
        return $optionsString;
    }

    /**
     * Executes Drush and runs a specified command
     */
    public function execute()
    {
        // Make sure we run Drush from build directory.
        chdir($this->phpci->buildPath);

        $drush = $this->executable;

        if (!$drush) {
            $this->phpci->logFailure(Lang::get('could_not_find', 'drush'));
            return false;
        }

        return $this->phpci->executeCommand(
          $drush . ' %1$s %2$s %3$s',
          $this->command,
          $this->arguments,
          $this->options
        );
    }
}
