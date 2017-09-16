<?php

namespace Jurgis\CompanyApiClient\Tests;
use Jurgis\CompanyApiClient\CompanyApiClient;
use Jurgis\CompanyApiClient\Provider\TestDataProvider;
use Jurgis\CompanyApiClient\Storage\TestStorage;
use Jurgis\CompanyApiClient\Entity\Quote;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

class CompanyApiClientLocalStorageTest extends BaseTestCase
{
    
    // TODO - POTENTIALLY SHOULD CREATE A TRAIT FOR THE CREATE APPLICATION
    
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../../../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
    
    public function testGetSavedQuotes() {       
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);
        $client->setLocalStorage(new TestStorage());
        
        $quotes = $client->getSavedQuotes('TESTCODE1');
        
        $this->assertEquals(1.15, $quotes->current()->getPrice());
        $this->assertEquals('TEST1', $quotes->current()->getSymbol());
        $this->assertInstanceOf('Carbon\Carbon', $quotes->current()->getQuoteDate());
        
        $quotes->next();
        $this->assertEquals(2.25, $quotes->current()->getPrice());
        $this->assertEquals('TEST2', $quotes->current()->getSymbol());
        $this->assertInstanceOf('Carbon\Carbon', $quotes->current()->getQuoteDate());
    }
    
    public function testSaveQuote() {
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);
        $client->setLocalStorage(new TestStorage());
        
        $quote = (new Quote())
            ->setPrice(1.21)
            ->setQuoteDate(new Carbon())
            ->setSymbol('SYM1');
        $this->assertTrue($client->saveQuote($quote));        
    }
    
    /**
     * Tests saving entry in DB from APP
     */
    public function testGetSavedQuotesLive() {       
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);                
        $quotes = $client->getSavedQuotes('SYM1');
        $this->assertGreaterThan(0, $quotes->current()->getPrice());
        $this->assertEquals('SYM1', $quotes->current()->getSymbol());
        $this->assertInstanceOf('Carbon\Carbon', $quotes->current()->getQuoteDate());

    }
    
    /**
     * Tests loading entry in DB from APP
     */
    public function testSaveQuoteLive() {
        $provider = new TestDataProvider();
        $client = new CompanyApiClient($provider);
        
        $quote = (new Quote())
            ->setPrice(1.21)
            ->setQuoteDate(new Carbon())
            ->setSymbol('SYM1');
        $this->assertTrue($client->saveQuote($quote));        
    }
    
}
