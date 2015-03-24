<?php

/* 
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


date_default_timezone_set('America/Vancouver');


define ('__SITE_PATH', $site_path);
define ('__CACHE_DIRECTORY', $site_path . '/app/cache');
define ('__LOG_PATH', $site_path . '/app/logs');

//include_once('phpunit.configuration.php');
require_once(__SITE_PATH . '/vendor/composer/ClassLoader.php');
$loader = new Composer\Autoload\ClassLoader();

// register classes with namespaces
      $loader->add('Gossamer\\Sockets', __SITE_PATH .'/src');
      $loader->add('Gossamer\\Horus', __SITE_PATH .'/vendor/gossamer/horus/src');
      $loader->add('Gossamer\\Pesedget', __SITE_PATH .'/vendor/gossamer/pesedget/src');
      $loader->add('Gossamer\\Caching', __SITE_PATH .'/vendor/gossamer/caching/src');

$loader->add('Monolog', __SITE_PATH.'/vendor/monolog/monolog/src');

// activate the autoloader
$loader->register();

// to enable searching the include path (eg. for PEAR packages)
$loader->setUseIncludePath(true);