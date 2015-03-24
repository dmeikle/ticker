<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace Gossamer\Sockets\EventListeners;

use Gossamer\Horus\EventListeners\AbstractListener;
use Gossamer\Horus\EventListeners\Event;
use Gossamer\Pesedget\Database\EntityManager;

/**
 * ServerEventListener
 *
 * @author Dave Meikle
 */
class ServerEventListener extends AbstractListener {
    
    public function on_server_initiate(Event $event) {        
        $this->logger->addInfo('Ticker Server initiating startup on ' . $event->getParam('host') . ':' . $event->getParam('port'));
        echo '>>Ticker Server initiating startup on ' . $event->getParam('host') . ':' . $event->getParam('port') . "\r\n";
    }
    
    public function on_server_startup(Event $event) {
        $this->logger->addInfo('Ticker Server successfully started');
        echo '>> Ticker Server sucessfully started on ' . $event->getParam('host') . ':' . $event->getParam('port') . "\r\n";
    }
    
    /**
     * used to check authorization token against an allowable list
     * 
     * @param Event $event
     */
    public function on_client_server_connect(Event $event) {
        echo "here is connection\r\n";
        print_r(EntityManager::getInstance()->getConnection());
    }
}
