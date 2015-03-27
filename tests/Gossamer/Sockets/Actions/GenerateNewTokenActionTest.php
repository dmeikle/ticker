<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace tests\Gossamer\Sockets\Actions;

use Gossamer\Sockets\Actions\GenerateNewTokenAction;
use Gossamer\Horus\EventListeners\Event;

/**
 * GenerateNewTokenAction
 *
 * @author Dave Meikle
 */
class GenerateNewTokenActionTest extends \tests\BaseTest {
    
    public function testGenerateNewToken() {
        $action = new GenerateNewTokenAction();
        
        $event = new Event('any_event', array());
        $action->execute($event);
        
    }
}
