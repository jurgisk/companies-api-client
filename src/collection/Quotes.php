<?php

namespace Jurgis\CompanyApiClient\Collection;
use Jurgis\CompanyApiClient\Entity\Quote;

/**
 * Quote collection
 *
 * @author jurgis
 */
class Quotes implements \Iterator {
    
    /**
     * @var Quote[]
     */
    private $list = [];
    
    /**
     * @param Quote $quote
     * @return Quotes
     */
    public function add(Quote $quote) : Quotes {
        $this->list[] = $quote;
        return $this;
    }

    public function rewind()
    {
        reset($this->list);
    }
  
    /**
     * @return Quote
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
     * @return Quote
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
