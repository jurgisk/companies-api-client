<?php

namespace Jurgis\CompanyApiClient\Collection;
use Jurgis\CompanyApiClient\Entity\Company;

/**
 * Description of Companies
 *
 * @author jurgis
 */
class Companies implements \Iterator {
    
    /**
     * @var Company[]
     */
    private $list = [];
    
    /**
     * @param Company $company
     * @return Companies
     */
    public function add(Company $company) : Companies {
        $this->list[] = $company;
        return $this;
    }

    public function rewind()
    {
        reset($this->list);
    }
  
    /**
     * @return Company
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
     * @return Company
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
