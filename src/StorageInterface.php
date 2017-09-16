<?php

namespace Jurgis\CompanyApiClient;
use Jurgis\CompanyApiClient\Collection\Quotes;
use Jurgis\CompanyApiClient\Entity\Quote;

/**
 *
 * @author jurgis
 */
interface StorageInterface {
    
    /**
     * @param Quote $quote
     */
    public function saveQuote(Quote $quote) : bool;
    
    /**
     * @return Quotes
     */
    public function getSavedQuotes(string $symbol) : Quotes;
    
    
    
}
