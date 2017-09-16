<?php

namespace Jurgis\CompanyApiClient\Entity;
use Carbon\Carbon;

/**
 * Quote data object
 *
 * @author jurgis
 */
class Quote {
    
    /**
     *
     * @var string
     */
    private $symbol;
    
    /**
     *
     * @var float
     */
    private $price;
    
    /**
     * @var Carbon
     */
    private $quoteDate;
    
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
    
    /**
     * 
     * @param float $value
     * @return $this
     */
    public function setPrice(float $value) {
        $this->price = $value;
        return $this;
    }
    
    /**
     * 
     * @return float
     */
    public function getPrice() {
        return $this->price;
    }
    
    /**
     * 
     * @param Carbon $date
     * @return $this
     */
    public function setQuoteDate(Carbon $date) {
        $this->quoteDate = $date;
        return $this;
    }
    
    /**
     * 
     * @return Carbon
     */
    public function getQuoteDate() {
        return $this->quoteDate;
    }
    
}
