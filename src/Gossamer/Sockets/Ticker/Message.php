<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Gossamer\Sockets\Ticker;

/**
 * Message
 *
 * @author Dave Meikle
 */
class Message {
    
    private $categoryId;
    
    private $message;
    
    function getCategoryId() {
        return $this->categoryId;
    }

    function getMessage() {
        return $this->message;
    }

    function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    function setMessage($message) {
        $this->message = $message;
    }


}
