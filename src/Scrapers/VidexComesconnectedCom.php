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
        // @todo use the crawler and assemble an array of Videx ValueObjects
        return [new Vo\Videx()];
    }

    /**
     * @param array $videxItems
     *
     * @return array|Vo\Videx[]
     */
    private function sort(array $videxItems): array
    {
        // @todo sort by annual price (desc)
        return $videxItems;
    }
}
