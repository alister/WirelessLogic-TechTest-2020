<?php

namespace App\Tests\Scrapers;

use PHPUnit\Framework\TestCase;
use App\Scrapers\VidexComesconnectedCom;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;

class VidexComesconnectedComTest extends TestCase
{
    public function testGetHtmlCrawler()
    {
        $videxComesConnected = $this->makeVidexComesConnectedComObject('<html> <body> <p>page</p> </body>');

        $actual = $videxComesConnected->getHtmlCrawler('https://example.com');
        $this->assertInstanceOf(Crawler::class, $actual);   // redundant with strong types
        
        $domNode = $actual->filter('p');
        $this->assertSame('page', $domNode->getNode(0)->nodeValue, 'Expected to get the p-text from test html');
    }

    public function testParse()
    {
        $videxComesConnected = $this->makeVidexComesConnectedComObject(
            file_get_contents(__DIR__. '/../fixtures/webpage.html')
        );

        $actual = $videxComesConnected->getHtmlCrawler('https://example.com');
        $domNodes = $actual->filter('#subscriptions div.package');
        $this->assertSame(6, $domNodes->count());   // 6 packages, 3 of them are annual copies though.

        $actual = $videxComesConnected->scrape('url');
        $this->assertCount(6, $actual);
    }

    private function makeVidexComesConnectedComObject(string $content): VidexComesconnectedCom
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent($content);

        $mockHttpBrowser = $this->createMock(HttpBrowser::class);
        $mockHttpBrowser->method('request')->willReturn($crawler);

        return new VidexComesconnectedCom($mockHttpBrowser);
    }
}
