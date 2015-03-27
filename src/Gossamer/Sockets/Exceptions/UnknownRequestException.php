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
 * UnknownRequestException
 *
 * @author Dave Meikle
 */
class UnknownRequestException extends \Exception{
    
    public function __construct ($message = '', $code = 400 , \Exception $previous = NULL ) {
        parent::__construct("Unkown request from server\r\n", $code, $previous);
    }
    
}
