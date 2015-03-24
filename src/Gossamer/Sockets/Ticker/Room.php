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

use Gossamer\Pesedget\Entities\AbstractEntity;
use Gossamer\Pesedget\Database\SQLInterface;

/**
 * Room
 *
 * @author Dave Meikle
 */
class Room extends AbstractEntity implements SQLInterface {
    
    public function __construct() {
        parent::__construct();
        $this->tablename = 'TickerRooms';
    }
    
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
    
    public function populate($params = array()) {
      
        $this->roomId = $params['id'];
        $this->roomName = $params['roomName'];       
    }
//TODO: remove this
//    public function notify(Message $message) {
//        foreach($this->listeners as $listener) {
//            @socket_write($listener->getSocket(),$message->getMessage(),strlen($message->getMessage()));
//        }
//    }
    
}
