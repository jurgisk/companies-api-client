<?php
namespace Jurgis\CompanyApiClient\Provider;

use Jurgis\CompanyApiClient\ProviderInterface;
use Jurgis\CompanyApiClient\Collection\{Companies, Quotes, Directors};
use Jurgis\CompanyApiClient\Entity\{Company, Quote, Director};
use Carbon\Carbon;


/**
 * Description of TestDataProvider
 *
 * @author jurgis
 */
class TestDataProvider implements ProviderInterface {
    /**
     * 
     * @return Companies
     */
    public function getCompnaies() : Companies {
        $companies = new Companies();       
        $companies
            ->add((new Company())->setName('First Test Company')->setSymbol('FT1'))
            ->add((new Company())->setName('Second Test Company')->setSymbol('STC1'));
        return $companies;
    }
    
    public function getQuote(string $symbol) : Quote {
        return (new Quote)->setSymbol($symbol)
            ->setPrice(10.21)
            ->setQuoteDate(new Carbon());
    }
    
    public function getDirectors(string $symbol) : Directors {
        $directors = new Directors();
        $director1 = (new Director())->setName('Test Director');
        $directors->add($director1);
        $director2 = (new Director())->setName('Another Director');
        $directors->add($director2);
        return $directors;
    }
    
}
