<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Gossamer\Sockets\Ticker;

/**
 * CustomRoom
 *
 * @author Dave Meikle
 */
class CustomRoom extends Room {
    
    public function isListening($categoryId) {
        //return true and let the individual user preference determine whether
        //they are listening or not
        return true;
    }
    
    
    public function notify(Message $message) {
        foreach($this->listeners as $listener) {
            //only notify them if they are interested in hearing about it
            if(in_array($message->getCategoryId(), $listener->getListeningCategoryIdList())) {
                @socket_write($listener,$message->getMessage(),strlen($message->getMessage()));
            }
        }
    }
}
