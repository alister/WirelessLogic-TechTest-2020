<?php
declare(strict_types=1);

namespace App\Scrapers;

use App\Vo;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class VidexComesconnectedCom implements Scraper
{
    /** @var \Symfony\Component\BrowserKit\HttpBrowser */
    private $httpBrowser;

    public function __construct(?HttpBrowser $httpBrowser = null)
    {
        $this->httpBrowser = $httpBrowser ?? new HttpBrowser(HttpClient::create());
    }

    /**
     * There should be 6 packages, but 4,5 & 6 are 'annual' options.
     * multiply the first 3 by x12 to get the comparable annual prices.
     * 
     * @param array|Vo\Videx[] $packages
     *
     * @return array|Vo\Videx[]  Also taking into account yearly packages
     */
    private function parsePackageData(array $packages): array
    {
        foreach (array_slice($packages, 0, 3) as $package) {
            $package->price *= 12;
        }
        
        return $packages;
    }

    /**
     * Sort by annual price (descending)
     * 
     * @param array $videxItems
     *
     * @return array|Vo\Videx[]
     */
    private function sort(array $videxItems): array
    {
        usort($videxItems, function(Vo\Videx $a, Vo\Videx $b) {
            // there isn't a 'ursort', so we reverse the spaceship comparison operands!
            return ($b->price <=> $a->price);
        });

        return $videxItems;
    }

    public function scrape(string $url, ?HttpBrowser $httpBrowser = null): array
    {
        // allows for a local override, if needed
        $this->httpBrowser = $httpBrowser ?? $this->httpBrowser;

        $crawler = $this->getHtmlCrawler($url);
        $videxItems = $this->parse($crawler);
        
        return $this->sort($videxItems);
    }

    public function getHtmlCrawler(string $url): Crawler
    {
        return $this->httpBrowser->request('GET', $url);
    }
    
    /**
     * The next step would be to make this a formal 'Collection' instead of internal-type of 'array'
     * 
     * @return array|Vo\Videx[]
     */
    private function parse(Crawler $crawler): array
    {
        $packages = $crawler->filter('#subscriptions div.package')->each(function (Crawler $node, $i) {
        
            $hasDiscount = $node->filter('p')->each(function (Crawler $node, $i) {
                return $node->text();
            });
            $discount = $hasDiscount ? current($hasDiscount) : '';
            
            return Vo\Videx::createFromArray([
                'id' => $i,
                'optionTitle' => $node->filter('h3')->text(),
                'desc' => $node->filter('.package-name')->text(),
                'price' => $node->filter('div.package-price span.price-big')->text(),
                'discount' => $discount,
            ]);
        });

        return $this->parsePackageData($packages);
    }
}
