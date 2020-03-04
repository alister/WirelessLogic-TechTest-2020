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
        $crawler = new Crawler();
        $crawler->addHtmlContent('<html> <body> <p>page</p> </body>');

        $mockHttpBrowser = $this->createMock(HttpBrowser::class);
        $mockHttpBrowser->method('request')
            ->willReturn($crawler);

        $videxComesConnected = new VidexComesconnectedCom($mockHttpBrowser);
        
        $actual = $videxComesConnected->getHtmlCrawler('https://example.com');
        $this->assertInstanceOf(Crawler::class, $actual);   // redundant with strong types
        
        $domNode = $actual->filter('p');
        $this->assertSame('page', $domNode->getNode(0)->nodeValue, 'Expected to get the p-text from test html');
    }

    public function testParse()
    {
        $this->markTestSKipped();
    }
}
