<?php


$site_path =  realpath(dirname(__FILE__));// strip the /web from it
require_once($site_path . '/includes/init.php');

    
use Gossamer\Sockets\Utils\YAMLParser;
use Gossamer\Horus\EventListeners\Event;
use Gossamer\Horus\EventListeners\EventDispatcher;
use Gossamer\Sockets\Servers\Server;
use Gossamer\Horus\Core\Request;
use Gossamer\Sockets\Ticker\Events;

//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

$config = loadConfiguration();

$eventDispatcher = new EventDispatcher($config, buildLogger($config), new Request() );
echo "dispatch event\r\n";
$eventDispatcher->dispatch('server', Events::SERVER_INITIATE, new Event(Events::SERVER_INITIATE, array('host' => $config['server']['host'], 'port' => $config['server']['port'])));
$server = new Server($config['server']['host'], $config['server']['port']);
$server->setEventDispatcher($eventDispatcher);
$server->execute();

function loadConfiguration() {
    $parser = new YAMLParser();
    $parser->setFilePath( __SITE_PATH . '/app/config/config.yml' );
    
    return $parser->loadConfig();
}

function buildLogger(array $config) {
      
    $loggerConfig = $config['logger'];
    
    $loggerClass = $loggerConfig['class'];    
    $logger = new $loggerClass('client-site');
    
    $handlerClass = $loggerConfig['handler']['class'];
    $logLevel = $loggerConfig['handler']['loglevel'];
    $logFile = $loggerConfig['handler']['logfile'];
    
    $maxFiles = null;
        if(array_key_exists('maxfiles', $loggerConfig['handler'])) {
        $maxFiles = $loggerConfig['handler']['maxfiles'];
    }
    if(is_null($maxFiles)) {
        $logger->pushHandler(new $handlerClass( __LOG_PATH . $logFile, $logLevel));
    } else {
        $logger->pushHandler(new $handlerClass( __LOG_PATH . $logFile, $maxFiles, $logLevel));
    }
        
    $logger->addInfo('logger built successfully');
    
    return $logger;
}

?>