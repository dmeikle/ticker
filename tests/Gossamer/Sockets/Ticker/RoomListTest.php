<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace tests\Gossamer\Sockets\Ticker;

use Gossamer\Sockets\Ticker\Room;
use Gossamer\Sockets\Ticker\RoomList;

/**
 * RoomListTest
 *
 * @author Dave Meikle
 */
class RoomListTest extends \tests\BaseTest{
   
    
    public function testAddRoom() {
        $list = new RoomList();        
        
        $list->addRoom($this->generateRoom('123', 'test room 123'));
        $list->addRoom($this->generateRoom('125', 'test room 125'));
        $list->addRoom($this->generateRoom('126', 'test room 126'));
        
        $this->assertEquals(3, $list->getCount());
    }
    
    public function testGetRoomById() {
        
        $list = new RoomList();        
        
        $list->addRoom($this->generateRoom('123', 'test room 123'));
        $list->addRoom($this->generateRoom('125', 'test room 125'));
        $list->addRoom($this->generateRoom('126', 'test room 126'));
        
        $room = $list->getRoomById('123');        
        $this->assertEquals('test room 123', $room->getRoomName());
        
        $room = $list->getRoomById('1');          
        $this->assertNull($room);
    }
    
    public function testSetRoomAsGroup() {
        $list = array();        
        
        $list[] = $this->generateRoom('123', 'test room 123');
        $list[] = $this->generateRoom('125', 'test room 125');
        $list[] = $this->generateRoom('126', 'test room 126');
        
        $roomList = new RoomList();
        $roomList->setRooms($list);
        
        $this->assertEquals(3, $roomList->getCount());
        
        $room = $roomList->getRoomById('123');        
        $this->assertEquals('test room 123', $room->getRoomName());
    }
    
    private function generateRoom($id, $name) {
        $room = new Room();
        $room->setRoomId($id);
        $room->setRoomName($name);
        
        return $room;
    }
}
