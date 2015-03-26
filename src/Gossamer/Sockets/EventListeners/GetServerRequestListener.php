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

use Gossamer\Horus\EventListeners\Event;
use Gossamer\Horus\EventListeners\AbstractListener;

/**
 * GetServerRequest
 *
 * @author Dave Meikle
 */
class GetServerRequestListeners extends AbstractListener{
 
    public function on_client_server_connect(Event $event) {
        $header = $event->getParam('header');
        echo "tada\r\n";
    }
}
