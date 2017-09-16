<?php

namespace Jurgis\CompanyApiClient\Tests;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Jurgis\CompanyApiClient\{CompanyApiClient, Provider\MannIslandSoapProvider, Provider\TestDataProvider};
use Carbon\Carbon;

class CompanyApiClientTest extends BaseTestCase
{
    /**
     * @expectedException Exception
     */
    public function testGetMannIslandProviderInvalidCredentials() {
        $provider = new MannIslandSoapProvider(
            ['Some array value']
        );
    }
    
    /**
     * @expectedException Exception
     */
    public function testGetMannIslandProviderInvalidCredentials2() {
        $provider = new MannIslandSoapProvider(
            ['user' => 'user', 'password' => 'pass', 'something_extra' => 1]
        );
    }
    
    public function testGetMannIslandProviderValidCredentials() {
        $provider = new MannIslandSoapProvider(
            ['user' => 'user', 'password' => 'pass']
        );
        $this->assertInstanceOf(
            'Jurgis\CompanyApiClient\Provider\MannIslandSoapProvider',
            $provider
        );
    }
    
    public function testGetClient() {
        $provider = new MannIslandSoapProvider(
            ['user' => 'jurgis', 'password' => 'Testing 123']
        );
        
        $client = new CompanyApiClient($provider);
        $this->assertInstanceOf('Jurgis\CompanyApiClient\CompanyApiClient', $client);
    }
    
    public function testGetCompanies() {       
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);
        $companies = $client->getCompanies();
        
        $this->assertEquals('First Test Company', $companies->current()->getName());
        $this->assertEquals('FT1', $companies->current()->getSymbol());
        
        $companies->next();
        $this->assertEquals('Second Test Company', $companies->current()->getName());
        $this->assertEquals('STC1', $companies->current()->getSymbol());
    }
    
    public function testGetCompanyBySymbol() {
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);       
        $company1 = $client->getCompanyBySymbol('FT1');
        $this->assertEquals('First Test Company', $company1->getName());
        $company2 = $client->getCompanyBySymbol('STC1');
        $this->assertEquals('Second Test Company', $company2->getName());
    }
    
    /**
     * @expectedException Exception
     */
    public function testGetCompanyBySymbolNoneExistingSymbol() {
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);       
        $company1 = $client->getCompanyBySymbol('ABABAB');
    }
    
    public function testGetQuote() {
        $now = new Carbon();
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);
        $quote = $client->getQuote('CODE1');
        $this->assertSame('CODE1', $quote->getSymbol());
        $this->assertSame(10.21, $quote->getPrice());
        $this->assertInstanceOf('Carbon\Carbon', $quote->getQuoteDate());
        $this->assertGreaterThanOrEqual($now, $quote->getQuoteDate());
    }
    
    public function testGetDirectors() {       
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);
        $directors = $client->getDirectors('SOMECODE');
        $this->assertEquals('Test Director', $directors->current()->getName());
        $directors->next();
        $this->assertEquals('Another Director', $directors->current()->getName());
    }
    
    
    // -------------- INTEGRATION TESTS BELOW - MOVE THEM TO A SEPARATE FILE ----------------
    
    /**
     * In order for this test to work you need your soap service running on http://localhost:8000/server.php?wsdl
     */
    private function getClient() {
        $provider = new MannIslandSoapProvider(
            ['user' => 'php-exercise@mannisland.co.uk', 'password' => 'p455w0rd']
        );    
        $client = new CompanyApiClient($provider);
        return $client;
    }
    
    public function testGetCompaniesLiveApi() {
        $companies = $this->getClient()->getCompanies();
        $this->assertEquals('GOOG', $companies->current()->getSymbol());
        $companies->next();
        $this->assertEquals('MSFT', $companies->current()->getSymbol());
        $companies->next();
        $this->assertEquals('IBM', $companies->current()->getSymbol());
    }
    
    public function testGetQuoteLiveApi() {
        $now = new Carbon();
        $quote = $this->getClient()->getQuote('GOOG');
        $this->assertGreaterThan(0, $quote->getPrice());
        $this->assertSame('GOOG', $quote->getSymbol());
        $this->assertInstanceOf('Carbon\Carbon', $quote->getQuoteDate());
        $this->assertGreaterThanOrEqual($now, $quote->getQuoteDate());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetQuoteLiveApiNoneExistingSymbol() {
        $quote = $this->getClient()->getQuote('SOME_OTHER_SYMBOL');
    }
    
    /**
     * @expectedException \Exception
     */
    public function testGetDirectorsLive() {
        $quote = $this->getClient()->getDirectors('SOMECODE');
    }
    
    
}
