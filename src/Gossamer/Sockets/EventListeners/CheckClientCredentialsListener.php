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
use Gossamer\Sockets\Exceptions\InvalidClientTokenException;

/**
 * CheckClientCredentialsListener
 *
 * @author Dave Meikle
 */
class CheckClientCredentialsListener extends AbstractListener{
    
    public function on_client_connect(Event $event) {
        $ip = $event->getParam('ipAddress');
        $token = $this->getClientToken($event->getParam('header'));
        
        if(!$event->getParam('tokenManager')->checkToken($ip, $token)) {
            throw new InvalidClientTokenException($ip.' with token '.$token);
        }
        
        $event->setParam('ClientToken', $event->getParam('tokenManager')->getToken($token));
    }
        
    private function getClientToken($header) {
        $headers = explode("\r\n", $header);
      
        foreach($headers as $row) {
           
            if(substr($row, 0, 4) == 'GET ' && (strpos('&token=', $row) > 0 || strpos('?token=', $row))) {
                $tmp = explode('token=', $row);
                $chunks = explode(' ', $tmp[1]);
                return trim($chunks[0]);
            }
        }
        
        return false;
    }
}
