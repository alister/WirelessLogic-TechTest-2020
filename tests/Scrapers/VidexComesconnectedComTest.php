<?php

namespace App\Tests\Scrapers;

use PHPUnit\Framework\TestCase;
use App\Scrapers\VidexComesconnectedCom;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\DomCrawler\Crawler;

class VidexComesconnectedComTest extends TestCase
{
    /** @var \App\Scrapers\VidexComesconnectedCom */
    private $v;
    /** @var \PHPUnit\Framework\MockObject\MockObject|\Symfony\Component\BrowserKit\HttpBrowser */
    private $mockHttpBrowser;

    protected function setUp(): void
    {
        $this->mockHttpBrowser = $this->createMock(HttpBrowser::class);
        $this->v = new VidexComesconnectedCom($this->mockHttpBrowser);
    }

    public function testGetHtmlCrawlerResults()
    {
        $crawler = new Crawler();
        $crawler->addHtmlContent('<html> <body> <p>page</p> </body>');

        $this->mockHttpBrowser->method('request')
            ->willReturn($crawler);

        $actual = $this->v->getHtmlCrawler('https://example.com');
        $this->assertInstanceOf(Crawler::class, $actual);
    }

    public function testScrape()
    {
        $this->markTestIncomplete();
    }
}
