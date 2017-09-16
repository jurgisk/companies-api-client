<?php

namespace Jurgis\CompanyApiClient;
use Jurgis\CompanyApiClient\{ProviderInterface, StorageInterface};
use Jurgis\CompanyApiClient\Collection\{Companies, Quotes, Directors};
use Jurgis\CompanyApiClient\Entity\{Quote, Company};
use Jurgis\CompanyApiClient\Storage\LocalStorage;

/**
 * Description of CompanyApiClient
 *
 * @author jurgis
 */
class CompanyApiClient
{     
    /**
     *
     * @var ProviderInterface
     */
    private $provider;
    
    /**
     *
     * @var StorageInterface
     */
    private $localStorage;
    
    public function __construct(ProviderInterface $provider) {
        $this->provider = $provider;
    }
    
    /**
     * @return Companies
     */
    public function getCompanies() : Companies {
        return $this->provider->getCompnaies();
    }
    
    public function getCompanyBySymbol(string $symbol) : Company {
        # TODO - PUT SOME CACHING ON THE LIST
        foreach ($this->provider->getCompnaies() as $company)
        {
            if ($company->getSymbol() == $symbol) {
                return $company;
            }
        }
        throw new \Exception('Company could not be found by the symbol provided');
    }
    
    public function getQuote(string $symbol) : Quote {
        return $this->provider->getQuote($symbol);
    }
    
    /**
     * 
     * @param StorageInterface $storage
     * @return $this
     */
    public function setLocalStorage(StorageInterface $storage) : CompanyApiClient {
        $this->localStorage = $storage;
        return $this;
    }
    
    /**
     * 
     * @return StorageInterface
     */
    private function getLocalStorage() : StorageInterface {
        if (!$this->localStorage) {
            $this->localStorage = new LocalStorage();
        }
        return $this->localStorage;
    }
    
    /**
     * 
     * @param string $symbol
     * @return Quotes
     */
    public function getSavedQuotes(string $symbol) : Quotes {
        return $this->getLocalStorage()->getSavedQuotes($symbol);
    }
    
    /**
     * 
     * @param Quote $quote
     * @return bool
     */
    public function saveQuote(Quote $quote) : bool {
        return $this->getLocalStorage()->saveQuote($quote);
    }
    
    public function getDirectors(string $symbol) : Directors {
        return $this->provider->getDirectors($symbol);
    }
    
}
