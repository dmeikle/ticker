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

use Gossamer\Horus\EventListeners\Event;
use Gossamer\Sockets\Actions\ActionInterface;
use Gossamer\Sockets\Exceptions\HeaderParametersMismatchException;

/**
 * SendClientNotificationAction
 *
 * @author Dave Meikle
 */
class SendClientNotificationAction  implements ActionInterface{
    
    use \Gossamer\Sockets\Traits\SendMessageTrait;
    
    public function __construct($params = null) {
        
    }

    public function execute(Event $event = null) {
        //first get the message details
        $details = $this->getHeaderParams($event->getParam('header'));
        if(count($details) != 2) {
            throw new HeaderParametersMismatchException();
        }
        $response_text = $this->mask(json_encode(array('type'=>'usermsg', 'name'=>'server', 'message'=>$details['message'], 'color'=>'#000000')));
       
        $event->getParam('concierge')->sendMessage($details['roomId'], $response_text);
    }

    private function getHeaderParams($header) {
        $headers = explode("\r\n", $header);
        $retval = array();
        foreach($headers as $row) {
          
            if(substr($row, 0, 7) == 'RoomId:') {
                $tmp = explode(': ', $row);
                
                $retval['roomId'] = trim($tmp[1]);
            }
            if(substr($row, 0, 8) == 'Message:') {
                $tmp = explode(': ', $row);
                
                $retval['message'] = trim($tmp[1]);
            }
        }
      
        return $retval;
    }
}
