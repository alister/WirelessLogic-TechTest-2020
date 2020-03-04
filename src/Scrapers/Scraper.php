<?php
declare(strict_types=1);

namespace App\Scrapers;

interface Scraper
{
    public function scrape(string $url): array;
}
