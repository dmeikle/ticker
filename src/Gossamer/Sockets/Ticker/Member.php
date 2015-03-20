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
 * Member
 *
 * @author Dave Meikle
 */
class Member {
   
    private $memberId;
    
    private $memberName;
    
    private $listeningCategoryIdList;
    
    private $socket;
    
    function getSocket() {
        return $this->socket;
    }

    function setSocket($socket) {
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
}
