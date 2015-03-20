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
 * RoomList
 *
 * @author Dave Meikle
 */
class RoomList {
   
    private $rooms;
    

    function addRoom(Room $room) {
        
        $rooms = $this->getRooms();
        
        $rooms[] = $room;
        
        $this->setRooms($rooms);
    }
 
    private function getRooms() {
        if(is_null($this->rooms)) {
            $this->rooms = array();
        }
        
        return $this->rooms;
    }
    
    public function setRooms(array $rooms) {
        $this->rooms = $rooms;
    }
    
    public function notifyRooms(Message $message) {
        foreach($this->rooms as $room) {
            if($room->isListening($message->getCategoryId())) {
                $room->notify($message);
            }
        }
    }
    
    public function getCount() {
                
        return count($this->getRooms());
    }
    
    public function getRoomById($roomId) {
        
        foreach($this->getRooms() as $room) {
            if($room->getRoomId() == $roomId) {
                return $room;
            }
        }
        
        return null;
    }
}


