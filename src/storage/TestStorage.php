<?php
namespace Jurgis\CompanyApiClient\Storage;
use Jurgis\CompanyApiClient\StorageInterface;
use Jurgis\CompanyApiClient\Collection\Quotes;
use Jurgis\CompanyApiClient\Entity\Quote;
use Carbon\Carbon;

/**
 *
 * @author jurgis
 */
class TestStorage implements StorageInterface {
    
    public function getSavedQuotes(string $symbol) : Quotes {
        $quotes = new Quotes();
        $quote1 = (new Quote())->setSymbol('TEST1')
            ->setPrice(1.15)
            ->setQuoteDate(new Carbon());
        $quotes->add($quote1);
        
        $quote2 = (new Quote())->setSymbol('TEST2')
            ->setPrice(2.25)
            ->setQuoteDate(new Carbon());
        $quotes->add($quote2);
        
        return $quotes;
    }
    
    public function saveQuote(Quote $quote): bool {
        return True;
    }

    
}
