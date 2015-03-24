<?php

/*
 *  This file is part of the Quantum Unit Solutions development package.
 * 
 *  (c) Quantum Unit Solutions <http://github.com/dmeikle/>
 * 
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */
namespace Gossamer\Sockets\Authorization\Commands;

use Gossamer\Pesedget\Database\QueryBuilder;


/**
 * LoadMemberCommand
 *
 * @author Dave Meikle
 */
class LoadMemberCommand extends AbstractCommand{
    
   
    public function execute($params = array()) {
        
        try{
            $this->getQueryBuilder()->setValues($params);
            $query = $this->getQueryBuilder(new $this->entity(), QueryBuilder::GET_ITEM_QUERY)->getQuery();
            
            $result = $this->query($query);
        } catch (Exception $ex) {

        }
        
        return $result;
    }

}
