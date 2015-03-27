<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Gossamer\Sockets\Authorization;

/**
 * TokenManager
 *
 * @author Dave Meikle
 */
class TokenManager {
    
    private $tokens;
    
    private $nextPruneTime;
    
    public function __construct() {
        $this->tokens = array();
        $this->tokens['123'] = array('ip' => '192.168.2.124', 'decayTime' => strtotime("+20 minutes"),'id' => 82);
        $this->tokens['124'] = array('ip' => '192.168.2.120', 'decayTime' => strtotime("+20 minutes"), 'id' => 2);
        
        $this->nextPruneTime = strtotime("+20 minutes");
    }
    public function setToken($ip, $token, $id) {
        $this->tokens[$token]['ip'] = $ip;
        $this->tokens[$token]['decayTime'] = strtotime("+20 minutes");
        $this->tokens[$token]['id'] = $id;
    }
    
    public function checkToken($ip, $token) {
        //seems like a logical place to call this based on public methods
        //$this->pruneTokens();
        if(strlen($token) == 0) {
            return false;
        }
        
        if(!array_key_exists($token, $this->tokens)) {
           
            return false;
        }
        
        //check to make sure token matches assigned and decay time is not exceeded
        return ($this->tokens[$token]['ip'] == $ip && $this->tokens[$token]['decayTime'] >= strtotime("now"));            
    }
    
    public function removeToken($ip) {
        unset($this->tokens[$ip]);
    }
    
    public function getToken($token) {
        if(array_key_exists($token, $this->tokens)) {
            return $this->tokens[$token];
        }
        
        return null;
    }
    
    private function pruneTokens() {
        $currentTime = strtotime("now");
        if($this->nextPruneTime < $currentTime) {
            foreach($this->tokens as $id => $token) {
                if($token['decayTime'] < $currentTime) {
                    unset($this->tokens[$id]);
                }
            }
        }
    }
}
