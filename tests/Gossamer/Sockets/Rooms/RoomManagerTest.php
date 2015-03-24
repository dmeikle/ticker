<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace tests\Gossamer\Sockets\Rooms;

use Gossamer\Sockets\Rooms\RoomManager;

/**
 * RoomManagerTest
 *
 * @author Dave Meikle
 */
class RoomManagerTest extends \tests\BaseTest{
    
   
    public function testLoadRoomList() {
        $mgr = new RoomManager();
        $list = $mgr->loadRoomList();
       print_r($list);
        $this->assertTrue(is_array($list));
        if(count($list) > 0) {
            $this->assertArrayHasKey('id', current($list));
        }
    }
}
