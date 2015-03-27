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

/**
 * RoomList
 *
 * @author Dave Meikle
 */
class RoomList {
   
    private $rooms;
    
    private $members;
    
    private $roomMemberList = array();
    
    function addRoom(Room $room) {
       
        $rooms = $this->getRooms();
        
        if(!array_key_exists($room->getRoomId(), $rooms)) {
            $rooms[$room->getRoomId()] = $room;
        }
       
        $this->rooms = $rooms;
        $roomMemberList = $this->getRoomMemberList();
        $roomMemberList[$room->getRoomId()] = $room->getMemberIdList();
        $this->roomMemberList = $roomMemberList;
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
    
    public function addMember(Member $member) {
     
        $roomMemberList = $this->getRoomMemberList();
        
        $members = $this->getMembers();
        $members[$member->getMemberId()] = $member;
        $this->members = $members;
        
        foreach($this->getRooms() as $room) {
            //check to see if they're allowed access and not already in this room
            if($this->memberAllowedAccess($member, $room) && !$this->checkMemberInRoom($member, $room, $roomMemberList)) {
               
                $this->roomMemberList[$room->getRoomId()][] = $member->getMemberId();
            } 
        }
        
    }
    
    private function checkMemberInRoom(Member $member, Room $room, array $roomMemberList) {
        if(!array_key_exists($room->getRoomId(), $roomMemberList)) {
            return false;
        }
        if(!in_array($member->getMemberId(), $roomMemberList[$room->getRoomId()])) {
            return false;
        }
        
        return true;
    }
    
    private function memberAllowedAccess(Member $member, Room $room) {
        
        return in_array($member->getMemberId(), $room->getMemberIdList());
    }
    
    private function getRoomMemberList($key = null) {
        if(is_null($this->roomMemberList)) {
            $this->roomMemberList = array();
        }
        if(!is_null($key) && array_key_exists($key, $this->roomMemberList)) {
            return $this->roomMemberList[$key];
        }
        
        return $this->roomMemberList;
    }
    
    private function getMembers() {
        if(is_null($this->members)) {
            $this->members = array();
        }
        
        return $this->members;
    }
    
    public function getCount() {
                
        return count($this->getRooms());
    }
    
    public function notifyRooms(Message $message) {
       
        //check to see if the intended message has an existing room
        if(!array_key_exists($message->getRoomId(), $this->getRoomMemberList())) {
          
            return;
        }
     
        $recipientList = $this->getRoomMemberList($message->getRoomId());
     
        foreach($recipientList as $memberId) {
           
            if(array_key_exists($memberId, $this->members)) {
               
                $this->members[$memberId]->notify($message);
            }
        }
        
    }
    
    public function removeMember($memberId) {               
        
        unset($this->members[$memberId]);
        foreach($this->getRoomMemberList() as $room) {
          
            //remove this member from any rooms
            unset($room[$memberId]);
        }
    }
}


