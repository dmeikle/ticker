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

/**
 * ActionInterface
 *
 * @author Dave Meikle
 */
interface ActionInterface {
    
    public function execute(Event $event = null);
    
    public function __construct($params = null);
}
