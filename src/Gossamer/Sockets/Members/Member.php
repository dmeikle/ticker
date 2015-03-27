<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Gossamer\Sockets\Members;

use Gossamer\Sockets\Ticker\Message;
use Gossamer\Pesedget\Entities\AbstractEntity;
use Gossamer\Pesedget\Database\SQLInterface;


/**
 * Member
 *
 * @author Dave Meikle
 */
class Member extends AbstractEntity implements SQLInterface{
   
    private $memberId;
    
    private $memberName;
    
    private $listeningCategoryIdList;
    
    private $socket;
    
    private $ipAddress;
    
    function getIpAddress() {
        return $this->ipAddress;
    }

    function setIpAddress($ipAddress) {
        $this->ipAddress = $ipAddress;
    }

    function getSocket() {
       
        return $this->socket;
    }

    function setSocket(&$socket) {
        $this->socket = $socket;       
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getMemberName() {
        return $this->memberName;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setMemberName($memberName) {
        $this->memberName = $memberName;
    }

    private function getListeningCategoryIdList() {
        if(is_null($this->listeningCategoryIdList)) {
            $this->listeningCategoryIdList = array();
        }
        
        return $this->listeningCategoryIdList;
    }
    
    public function setListeningCategoryIdList(array $list) {
        $this->listeningCategoryIdList = $list;
    }
    
    public function addListeningCategoryId($categoryId) {
        $list = $this->getListeningCategoryIdList();
        
        $list[] = $categoryId;
        
        $this->listeningCategoryIdList = $list;
    }
    
    public function notify(Message $message) {
      
        socket_write($this->getSocket(),$message->getMessage(),strlen($message->getMessage()));
            //only notify them if they are interested in hearing about it
            if(in_array($message->getCategoryId(), $this->getListeningCategoryIdList())) {
               
                @socket_write($this->getSocket(),$message->getMessage(),strlen($message->getMessage()));
            }
        
    }
}
