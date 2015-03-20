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
 * Room
 *
 * @author Dave Meikle
 */
class Room {
    
    private $roomName;
    
    private $roomId;
    
    private $memberIds;
    
    public function getRoomName() {
        return $this->roomName;
    }

    public function getRoomId() {
        return $this->roomId;
    }

    public function setRoomName($roomName) {
        $this->roomName = $roomName;
    }

    public function setRoomId($roomId) {
        $this->roomId = $roomId;
    }

    public function setMemberIdList(array $ids) {
        $this->memberIds = $ids;
    }
    
    public function getMemberIdList() {
        if(is_null($this->memberIds)) {
            $this->memberIds = array();
        }
        
        return $this->memberIds;
    }
    
//TODO: remove this
    public function notify(Message $message) {
        foreach($this->listeners as $listener) {
            @socket_write($listener->getSocket(),$message->getMessage(),strlen($message->getMessage()));
        }
    }
    
}
