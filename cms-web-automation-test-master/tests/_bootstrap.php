<?php
// This is global bootstrap for autoloading
$find = array_search('--env', $_SERVER['argv']);
$env = $find ? $_SERVER['argv'][$find + 1] : 'staging';
defined('APPLICATION_ENV') || define('APPLICATION_ENV', $env);

\Codeception\Util\Autoload::registerSuffix('Page', __DIR__.DIRECTORY_SEPARATOR.'_pages');

date_default_timezone_set('America/Los_Angeles');