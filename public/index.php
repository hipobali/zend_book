<?php
spl_autoload_register(function($classname){
    return @include str_replace('_', DIRECTORY_SEPARATOR, $classname).'.php';
});
// echo"hello";
// Setting the cache limiter to nocache
session_cache_limiter('nocache');

date_default_timezone_set('Asia/Rangoon');

mb_regex_encoding("utf-8");
// internal Encoding settings...
mb_internal_encoding("utf-8");
/// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library/pear/php'),
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

require_once 'Zend/Loader/PluginLoader.php';
$cachefile = APPLICATION_PATH . '/../data/cache/plugins.php';
if (file_exists($cachefile)) {
    include_once $cachefile;
}
Zend_Loader_PluginLoader::setIncludeFileCache($cachefile);
/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();