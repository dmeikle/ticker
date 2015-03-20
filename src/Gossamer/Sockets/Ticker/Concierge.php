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
    
    private $memberCount = 0;
    
    public function __construct() {
        $this->roomList = new RoomList();
        $this->initRooms();
    }
    
    private function initRooms() {
        $room = new Room();
        $room->setRoomId('1');
        $room->setRoomName('emergency');
        $room->setMemberIdList(array('192.168.2.120', '192.168.2.124', '192.168.2.132'));
        $this->roomList->addRoom($room);
        
        $room = new Room();
        $room->setRoomId('2');
        $room->setRoomName('construction');
        $this->roomList->addRoom($room);
        
    }
    
    /**
     * use the IP to identify the user
     * 
     * @param string $ip
     * @param type $socket
     */
    public function addSocket($ip, &$socket) {
        $member = new Member();
        $member->setMemberId($ip);
        $member->setSocket($socket);
        //$member->setMemberId($this->memberCount++);
        $this->roomList->addMember($member);
    }
    
    public function removeSocket($ip) {
        $this->roomList->removeMember($ip);
    }
    
    public function sendMessage($roomId, $msg) {
        $message = new Message();
        $message->setRoomId($roomId);
        $message->setMessage($msg);
        
        $this->roomList->notifyRooms($message);
    }

}
