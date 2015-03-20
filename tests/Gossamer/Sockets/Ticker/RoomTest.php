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

/**
 * RoomTest
 *
 * @author Dave Meikle
 */
class RoomTest extends \tests\BaseTest{
    
    
    public function testSetRoomName() {
        $room = new Room();
        
        $room->setRoomName('Construction');
        
        print_r($room->getRoomName());
    }
}
