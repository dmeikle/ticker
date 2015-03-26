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
use Gossamer\Aker\Authorizations\Listeners\CheckServerCredentialsListener as BaseListener;
/**
 * CheckServerCredentialsListener
 *
 * @author Dave Meikle
 */
class CheckServerCredentialsListener extends BaseListener {
    
    
    public function on_client_server_connect(Event $event) {
        if(!$this->checkServer($event->getParam('token'), $event->getParam('ipAddress'))) {
            $this->logger->addError('CheckServerCredentialsListener::on_client_server_connect has mismatched serverAuth information');
            throw new UnauthorizedAccessException($event->getParam('ipAddress') . ' is not authorized');
        }
    }
    
}
