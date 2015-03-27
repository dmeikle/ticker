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

use Gossamer\Sockets\Members\Member;
use Gossamer\Sockets\Rooms\RoomManager;
use Gossamer\Sockets\Authorization\Commands\ListCommand;
use Gossamer\Pesedget\Database\EntityManager;
use Gossamer\Sockets\Entities\TickerRoomStaff;

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

        $roomManager = new RoomManager();
        
        $roomList = $roomManager->loadRoomList();
        
        foreach($roomList as $roomEntity) {
            $room = new Room();
            $room->populate($roomEntity); //transfer the db values to the accessors
            $room->setMemberIdList($this->loadRoomStaff($room->getRoomId()));
            $this->roomList->addRoom($room);
           
        }
        
//        $room = new Room();
//        $room->setRoomId('1');
//        $room->setRoomName('emergency');
//        $room->setMemberIdList(array('192.168.2.120', '192.168.2.124', '192.168.2.132'));
//        $this->roomList->addRoom($room);
//        
//        $room = new Room();
//        $room->setRoomId('2');
//        $room->setRoomName('construction');
//        $this->roomList->addRoom($room);
        print_r($this->roomList);
    }
    
    private function loadRoomStaff($roomId) {
                
        $cmd = new ListCommand(new TickerRoomStaff(), null, EntityManager::getInstance()->getConnection());
        
        $result = $cmd->execute(array('TickerRooms_id' => $roomId));
        unset($cmd);
        
        return array_column($result, 'Staff_id');
    }
    
    /**
     * use the IP to identify the user
     * 
     * @param string $ip
     * @param type $socket
     */
    public function addSocket($token, &$socket, $id) {
        $member = new Member();
        print_r($token);
        echo "addsocket::memberId " . $token['id'] . "\r\n";
        $member->setMemberId( $token['id']);
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
