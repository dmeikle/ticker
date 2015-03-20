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
    
    
    private $chatters;
    
    private $listeners;
    
    private $categoryIdList;
    
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

    public function addCategoryId($categoryId) {
        $list = $this->getCategoryIdList();
        $list[] = $categoryId;
        
        $this->categoryIdList = $list;
    }

    protected function getListeners() {
        if(is_null($this->listeners)) {
            $this->listeners = array();
        }
        
        return $this->listeners;
    }

    protected function getChatters() {
        if(is_null($this->chatters)) {
            $this->chatters = array();
        }
        
        return $this->chatters;
    }

    protected function getCategoryIdList() {
        if(is_null($this->categoryIdList)) {
            $this->categoryIdList = array();
        }
        
        return $this->categoryIdList;
    }
    
    public function isListening($categoryId) {
        return in_array($categoryId, $this->categoryIdList);
    }
    
    public function notify(Message $message) {
        foreach($this->listeners as $listener) {
            @socket_write($listener->getSocket(),$message->getMessage(),strlen($message->getMessage()));
        }
    }
    
    public function addListener(Member $member) {
        $listeners = $this->getListeners();
        
        $listeners[] = $member;
        
        $this->listeners = $listeners;
    }
}
