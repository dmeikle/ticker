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

use Gossamer\Sockets\Entities\TickerRoomStaff;
use Gossamer\Sockets\Authorization\Commands\ListCommand;

/**
 * TickerRoomStaffTest
 *
 * @author Dave Meikle
 */
class TickerRoomStaffTest extends \tests\BaseTest{
 
    public function testLoadStaffByRoomId() {
                
        $cmd = new ListCommand(new TickerRoomStaff(),null, \Gossamer\Pesedget\Database\EntityManager::getInstance()->getConnection());
        $list = $cmd->execute(array('TickerRooms_id' => 1));
        print_r($list);
        $this->assertTrue(is_array($list));
        print_r(array_column($list, 'Staff_id'));
    }
}
