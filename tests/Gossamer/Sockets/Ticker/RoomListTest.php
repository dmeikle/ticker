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
use Gossamer\Sockets\Members\Member;
use Gossamer\Sockets\Ticker\Message;

/**
 * RoomListTest
 *
 * @author Dave Meikle
 */
class RoomListTest extends \tests\BaseTest{
   
    
    private function generateRoom($id, $name, $exclude = null) {
        $room = new Room();
        $room->setRoomId($id);
        $room->setRoomName($name);
        $list = array(1,2,3);
        
        if(!is_null($exclude)) {
            unset($list[$exclude]);
        }
       
        $room->setMemberIdList($list);
        
        return $room;
    }
    
    public function testAddRoom() {
        $list = new RoomList();        
        
        $list->addRoom($this->generateRoom('123', 'test room 123'));
        $list->addRoom($this->generateRoom('125', 'test room 125'));
        $list->addRoom($this->generateRoom('126', 'test room 126'));
        
        $this->assertEquals(3, $list->getCount());
    }
    
    public function testSetRoomAsGroup() {
        $list = array();        
        
        $list[] = $this->generateRoom('123', 'test room 123');
        $list[] = $this->generateRoom('125', 'test room 125');
        $list[] = $this->generateRoom('126', 'test room 126');
        
        $roomList = new RoomList();
        $roomList->setRooms($list);
        
        $this->assertEquals(3, $roomList->getCount());
        
    }
    
    public function testAddNewMembersToRoom() {
        $list = new RoomList();        
        $list->addRoom($this->generateRoom('123', 'test room 123'));
        $list->addRoom($this->generateRoom('125', 'test room 125'));
        $list->addRoom($this->generateRoom('126', 'test room 126'));
        
        $member = new Member();
        $member->setMemberId(1);
        $member->setMemberName('Dave');
        $member->setListeningCategoryIdList(array(1,2,3));
        
        $list->addMember($member);
        $list->addMember($member);
    }
    
    /**
     * @group message
     */
    public function testSendMessageToRoom() {
        $list = new RoomList();    
     
        $list->addRoom($this->generateRoom('123', 'test room 123'));
        //exclude Mike
        $list->addRoom($this->generateRoom('125', 'test room 125', 1)); //2nd index
        $list->addRoom($this->generateRoom('126', 'test room 126'));
      
        $member = new Member();
        $member->setMemberId(1);
        $member->setMemberName('Dave');
        $member->setListeningCategoryIdList(array(1,2,3));        
        $list->addMember($member);
        
        $member = new Member();
        $member->setMemberId(2);
        $member->setMemberName('Mike');
        $member->setListeningCategoryIdList(array(1));       
        $list->addMember($member);
        
        $message = new Message();
        $message->setCategoryId(1);
        $message->setEventName('phase_change');
        $message->setRoomId(123);
        $message->setMessage('this is dummy data');
        
        $list->notifyRooms($message);
    }
}
