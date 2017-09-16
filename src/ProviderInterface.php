<?php

namespace Jurgis\CompanyApiClient;
use Jurgis\CompanyApiClient\Collection\{Companies, Quotes, Directors};
use Jurgis\CompanyApiClient\Entity\Quote;

/**
 *
 * @author jurgis
 */
interface ProviderInterface {
    
    /**
     * @return Companies
     */
    public function getCompnaies() : Companies;
    
    /**
     * @return Quote
     */
    public function getQuote(string $symbol) : Quote;
    
    /**
     * @return Directors
     */
    public function getDirectors(string $symbol) : Directors;
    
}
