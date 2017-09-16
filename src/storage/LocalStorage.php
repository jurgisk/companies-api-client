<?php

namespace Jurgis\CompanyApiClient\Storage;
use Jurgis\CompanyApiClient\StorageInterface;
use Jurgis\CompanyApiClient\Collection\Quotes;
use Jurgis\CompanyApiClient\Entity\Quote;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 *
 * @author jurgis
 */
class LocalStorage implements StorageInterface {
    
    public function getSavedQuotes(string $symbol) : Quotes {
        $quotes = new Quotes();
        
        try {
            $entries = DB::table('saved_quotes')
                ->select('symbol', 'saved_time', 'price')
                ->where('symbol', '=', $symbol)
                ->orderBy('id', 'asc')
                ->get();
        } catch (\Exception $ex) {
            throw new \Exception('Failed to load saved quotes from db');
        }
        
        foreach($entries as $row)
        {           
            $quote = (new Quote())->setSymbol($row->symbol)
            ->setPrice($row->price)
            ->setQuoteDate(new Carbon($row->saved_time));
            $quotes->add($quote);
        }
        
        return $quotes;
    }
    
    public function saveQuote(Quote $quote): bool {
        try {
            DB::table('saved_quotes')->insert(
                [
                    'symbol' => $quote->getSymbol(), 
                    'saved_time' => $quote->getQuoteDate()->format('Y-m-d H:i:s'),
                    'price' => $quote->getPrice(),
                ]
            );
        } catch (\Exception $ex) {
            throw new \Exception('Failed to save quote');
        }
        return true;
    }

    
}
