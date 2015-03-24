<?php
namespace Gossamer\Sockets\Authorization\Commands;

use Gossamer\Sockets\Authorization\Commands\AbstractCommand;
use Gossamer\Pesedget\Database\QueryBuilder;
use Gossamer\Pesedget\Entities\OneToOneJoinInterface;


/**
 * List All Command Class
 *
 * Author: Dave Meikle
 * Copyright: Quantum Unit Solutions 2013
 */
class ListCommand extends AbstractCommand
{

    /**
     * retrieves a multiple rows from the database
     *
     * @param array     URI params
     * @param array     POST params
     */
    public function execute($params = array()){
    
        if($this->entity instanceof OneToOneJoinInterface) { 
           if(array_key_exists('locale', $params)) {
               $this->getQueryBuilder()->where($params['locale']);
           }
            
            $this->getQueryBuilder()->join($this->entity->getJoinRelationships());
        }
     
        $this->getQueryBuilder()->where($params);
        
        $query = $this->getQueryBuilder()->getQuery($this->entity, QueryBuilder::GET_ALL_ITEMS_QUERY, QueryBuilder::PARENT_AND_CHILD);
   
        $result = $this->query($query);
        
        return $result;
    }
    
    

    
}
