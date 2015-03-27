<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace tests\Gossamer\Sockets\EventListeners;

use Gossamer\Sockets\EventListeners\GetServerRequestListener;
use Gossamer\Horus\EventListeners\Event;

/**
 * GetServerRequestListenerTest
 *
 * @author Dave Meikle
 */
class GetServerRequestListenerTest extends \tests\BaseTest{
    
    public function testGenerateNewClientToken() {
        $listener = new GetServerRequestListener($this->getLogger());
        $header = "GET /echo HTTP/1.1\r\nUpgrade: WebSocket\r\nConnection: Upgrade\r\nHost: 192.168.2.252:9000\r\nOrigin: http://foobar.com\r\nServerAuthToken: 123456\r\nRequest: REQUEST_NEW_TOKEN\r\nSec-WebSocket-Key: evERDvQ Jw()uvAj}RCHI5 L6  } J\r\nSec-WebSocket-Key1: evERDvQ Jw()uvAj}RCHI5 L6  } J\r\nSec-WebSocket-Key2: &Vjp) vbm 9WA BFgP 9vUDIZ2 O)kXj\r\n\r\nIZ0g8hb▒\r\n";

        $event = new Event('on_client_server_request', array('header' => $header));
        $listener->on_client_server_request($event);
        $this->assertEquals('NEW_TOKEN', substr($event->getParam('ACTION_RESPONSE'), 0, 9));
    }
    
}
