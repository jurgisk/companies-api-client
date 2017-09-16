<?php

namespace Jurgis\CompanyApiClient\Entity;

/**
 * Director data object
 *
 * @author jurgis
 */
class Director {
    /**
     *
     * @var string
     */
    private $name;
    
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
}
