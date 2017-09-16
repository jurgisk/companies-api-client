<?php

namespace Jurgis\CompanyApiClient\Collection;
use Jurgis\CompanyApiClient\Entity\Director;

/**
 * Director collection
 *
 * @author jurgis
 */
class Directors implements \Iterator {
    
    /**
     * @var Director[]
     */
    private $list = [];
    
    /**
     * @param Director $director
     * @return Directors
     */
    public function add(Director $director) : Directors {
        $this->list[] = $director;
        return $this;
    }

    public function rewind()
    {
        reset($this->list);
    }
  
    /**
     * @return DIrector
     */
    public function current()
    {
        return current($this->list);
    }
  
    public function key() 
    {
        return key($this->list);
    }
  
    /**
     * @return Director
     */
    public function next() 
    {
        return next($this->list);
    }
  
    public function valid()
    {
        $key = key($this->list);
        return ($key !== NULL && $key !== FALSE);
    }
    
}
