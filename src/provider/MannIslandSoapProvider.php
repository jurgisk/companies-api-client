<?php

namespace Jurgis\CompanyApiClient\Provider;
use Jurgis\CompanyApiClient\ProviderInterface;
use Jurgis\CompanyApiClient\Collection\{Companies, Quotes, Directors};
use Jurgis\CompanyApiClient\Entity\{Company, Quote, Director};
use SoapClient;
use SoapFault;
use Carbon\Carbon;

/**
 * Description of MannIslandSoapProvider
 *
 * @author jurgis
 */
class MannIslandSoapProvider implements ProviderInterface {
    
    private $credentials = [
        'user' => false,
        'password' => false,
    ];
    
    /**
     * @var SoapClient
     */
    private $soapClient;
    
    /**
     * @param array $credentials ['user' => 'string', 'password' => 'string']
     * @return MannIslandSoapProvider
     * @throws \InvalidArgumentException
     */
    public function __construct(array $credentials)
    {
        $this->setCredentials($credentials);
    }
    
    /**
     * @param array $credentials ['user' => 'string', 'password' => 'string']
     * @return MannIslandSoapProvider
     * @throws \InvalidArgumentException
     */
    private function setCredentials(array $credentials) {
        $credential_problems = [];
        
        if (!isset($credentials['user']) || !is_string($credentials['user'])) {
            $credential_problems[] = 'user must be provided as a string';
        }
        
        if (!isset($credentials['password']) || !is_string($credentials['password'])) {
            $credential_problems[] = 'password must be provided as a string';
        }
        
        if (count($credentials) !== 2) {
            $credential_problems[] = 'There should be only user and password in credentials array';
        }
        
        if ($credential_problems) {
            throw new \InvalidArgumentException(
                implode(', ', $credential_problems)
            );
        }
        $this->credentials = $credentials;
        return $this;
    }
    
    private function getSoapCredentials() {
        return [
            $this->credentials['user'],
            $this->credentials['password'],
        ];
    }
    
    private function getSoapClient() {
        if (!$this->soapClient) {
            # TODO - CREDENTIALS SHOULD COME FROM INI FILE
            $this->soapClient = new SoapClient("http://localhost:8000/server.php?wsdl");
        }
        return $this->soapClient;
    }
    
    /**
     * 
     * @return Companies
     */
    public function getCompnaies() : Companies {
        $companies = new Companies();
        try { 
            $return = $this->getSoapClient()->getCompanies($this->getSoapCredentials());
            foreach ($return->item as $row)
            {
                $company = (new Company())
                    ->setName($row['name'])
                    ->setSymbol($row['symbol']);
                $companies->add($company);
            }
        } catch (SoapFault $fault) {
            throw new \Exception('Failed to do API call to get companies');
        }
        
        return $companies;
    }
    
    public function getQuote(string $symbol) : Quote {
        
        try { 
            $price = $this->getSoapClient()->getQuote(
                    $this->getSoapCredentials(),
                    $symbol
            );
        } catch (SoapFault $fault) {            
            if ($fault->getMessage() == 'Could not find stock price') {
                throw new \InvalidArgumentException('There is no price for this symbol');
            } else {
                throw new \Exception('Failed to do API call to get quote');
            }
        }
        
        return (new Quote)->setSymbol($symbol)
            ->setPrice($price)
            ->setQuoteDate(new Carbon());
    }
    
    public function getDirectors(string $symbol) : Directors {
        $directors = new Directors();        
        try { 
            $directorList = $this->getSoapClient()->getDirectorsBySymbol(
                    $this->getSoapCredentials(),
                    $symbol
            );
            
            # Here we would have some code to populate the directors, but the API
            # is not going to give any response - so I dont know what the response
            # structure is or what the variables returned are.
            # So the code below is just for demonstration
            foreach ($directorList->item as $row)
            {
                $director = (new Director())->setName($row['name']);
                $directors->add($director);
            }
            
        } catch (SoapFault $fault) {            
            throw new \Exception('Failed to get directors from API');
        }
        
        return $directors;
    }
    
}
