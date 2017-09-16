<?php

namespace Jurgis\CompanyApiClient\Entity;

/**
 * Company data object
 *
 * @author jurgis
 */
class Company {
    /**
     *
     * @var string
     */
    private $name;
    
    /**
     *
     * @var string
     */
    private $symbol;
    
    /**
     * 
     * @param string $value
     * @return $this
     */
    public function setName(string $value) {
        $this->name = $value;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * 
     * @param string $value
     * @return $this
     */
    public function setSymbol(string $value) {
        $this->symbol = $value;
        return $this;
    }
    
    /**
     * 
     * @return string
     */
    public function getSymbol() {
        return $this->symbol;
    }
    
}
