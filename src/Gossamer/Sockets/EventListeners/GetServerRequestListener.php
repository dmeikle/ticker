<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Gossamer\Sockets\EventListeners;

use Gossamer\Horus\EventListeners\Event;
use Gossamer\Horus\EventListeners\AbstractListener;
use Gossamer\Sockets\Actions\Actions;
use Gossamer\Sockets\Exceptions\UnknownRequestException;
use Gossamer\Sockets\Actions\GenerateNewTokenAction;
use Gossamer\Sockets\Actions\SendClientNotificationAction;

/**
 * GetServerRequest
 *
 * @author Dave Meikle
 */
class GetServerRequestListener extends AbstractListener{
 
    public function on_client_server_request(Event $event) {
        $header = $event->getParam('header');
        
        $action = $this->getAction($this->getRequestType($header));
        if(is_null($action)) {
            throw new UnknownRequestException();
        }
       
        $action->execute($event);
    }
    
    private function getAction($requestType) {
        
        if($requestType == Actions::REQUEST_NEW_TOKEN) {
            return new GenerateNewTokenAction();
        } elseif ($requestType == Actions::CHANGE_CLIENT_PREFERENCE) {
            return new ChangeClientPreferenceAction();
        } elseif ($requestType == Actions::CHANGE_CLIENT_ACCESS) {
            return new ChangeClientAccessAction();
        } elseif($requestType == Actions::SEND_CLIENT_NOTIFICATION) {
            return new SendClientNotificationAction();
        }
        
        return null;
    }
    
    private function getRequestType($header) {
        
        $pieces = explode("\r\n", $header);
       
        foreach($pieces as $chunk) {
           
            if(substr($chunk,0,8) == 'Request:') {
                $retval = explode(':', $chunk);
                                
                return trim($retval[1]);
            }
        }
    }
}
