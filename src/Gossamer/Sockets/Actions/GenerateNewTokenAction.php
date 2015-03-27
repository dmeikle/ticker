<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Gossamer\Sockets\Actions;

use Gossamer\Sockets\Actions\ActionInterface;
use Gossamer\Horus\EventListeners\Event;
use Gossamer\Sockets\Actions\Actions;

/**
 * GenerateNewTokenAction
 *
 * @author Dave Meikle
 */
class GenerateNewTokenAction implements ActionInterface{
    
    public function __construct($params = null) {
        
    }

    public function execute(Event $event = null) {
        $token = uniqid();
        $event->setParam(Actions::ACTION_RESPONSE, 'NEW_TOKEN: ' . $token);
        $event->getParam('tokenManager')->setToken($this->getClientIp($event->getParam('header')), $token, $this->getStaffId($header));
    }

    private function getStaffId($header) {
        $headers = explode("\r\n", $header);
  
        foreach($headers as $row) {
           
            if(substr($row, 0, 8) == 'StaffId:') {
                $tmp = explode(':', $row);
               
                return trim($tmp[1]);
            }
        }
        
        return false;
    }
    
    private function getClientIp($header) {
        $headers = explode("\r\n", $header);
  
        foreach($headers as $row) {
           
            if(substr($row, 0, 9) == 'ClientIp:') {
                $tmp = explode(':', $row);
               
                return trim($tmp[1]);
            }
        }
        
        return false;
    }
}
