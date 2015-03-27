<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Gossamer\Sockets\Exceptions;

/**
 * InvalidClientTokenException
 *
 * @author Dave Meikle
 */
class InvalidClientTokenException extends \Exception {
    
    public function __construct ($ipAddress, $code = 401 , \Exception $previous = NULL ) {
        parent::__construct('Invalid Client connection attempt from ' . $ipAddress . "\r\n", $code, $previous);
    }
}
