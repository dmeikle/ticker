<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */


namespace Gossamer\Sockets\Utils;

use Symfony\Component\Yaml\Yaml;
use Monolog\Logger;

/**
 * YAMLParser
 *
 * @author Dave Meikle
 */

class YAMLParser
{
    protected $ymlFilePath = null;
    
    protected $logger = null;
    
    public function __construct(Logger $logger = null) {
        $this->logger = $logger;
    }
    
    public function findNodeByURI( $uri, $searchFor) {
        if(!is_null($this->logger)) {
            $this->logger->addDebug('YAMLParser opening ' . $this->ymlFilePath);
        }
        $config = $this->loadConfig();
       
        if(!is_array($config)) {
            return null;
        }
       
        if(array_key_exists($uri, $config) && array_key_exists($searchFor, $config[$this->getSectionKey($uri)])) {
         
            return $config[$this->getSectionKey($uri)][$searchFor];
                        
        }
        return null;
    }
    
    public function loadConfig() {
        return Yaml::parse($this->ymlFilePath);
    }
    private function getSectionKey($uri) {
        
        $pieces = explode('/',strtolower($uri));
        $pieces = array_filter($pieces);

        return implode('_', $pieces);
    }
    
    public function setFilePath($ymlFilePath) {
        $this->ymlFilePath = $ymlFilePath;
    }
}
