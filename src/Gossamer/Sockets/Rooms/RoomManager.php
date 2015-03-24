<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace Gossamer\Sockets\Rooms;

use Gossamer\Sockets\Authorization\Commands\ListCommand;
use Gossamer\Pesedget\Database\EntityManager;
use Gossamer\Sockets\Ticker\Room;

/**
 * RoomManager
 *
 * @author Dave Meikle
 */
class RoomManager {

    
    public function loadRoomList() {
        $cmd = new ListCommand(new Room(), null, EntityManager::getInstance()->getConnection());
        
        $result = $cmd->execute();
        unset($cmd);
        
        return $result;
    }
}
