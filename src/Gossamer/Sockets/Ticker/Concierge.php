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
 * Concierge
 *
 * @author Dave Meikle
 */
class Concierge {
    
    private $roomList;
    
    public function __construct() {
        $roomList = new RoomList();
        $this->initRooms();
    }
    
    private function initRooms() {
        $room = new Room();
        $room->setRoomId('room1');
        $room->setRoomName('emergency');
        $this->roomList->addRoom($room);
        
        $room = new Room();
        $room->setRoomId('room2');
        $room->setRoomName('construction');
        $this->roomList->addRoom($room);
        
    }
    
    public function notify() {
        
    }
}
