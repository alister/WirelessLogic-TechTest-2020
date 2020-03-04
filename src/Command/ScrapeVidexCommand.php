<?php
declare(strict_types=1);

namespace App\Command;

use App\Scrapers\VidexComesconnectedCom;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ScrapeVidexCommand extends Command
{
    protected static $defaultName = 'app:scrape:videx';
    /** @var \App\Scrapers\VidexComesconnectedCom */
    private $scraper;

    public function __construct(VidexComesconnectedCom $scraper, string $name = null)
    {
        parent::__construct($name);
        $this->scraper = $scraper;
    }

    protected function configure()
    {
        $this
            ->setDescription('Scrape the //videx.comesconnected.com webpage to collect data')
            ->addArgument('url', InputArgument::OPTIONAL, 'URL to scrape', 'https://videx.comesconnected.com/')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');

        try {
            $collectedData = $this->scraper->scrape($url);
            if ($collectedData) {
                $io->note(json_encode($collectedData));
                return 0;
            }            
        } catch (\Throwable $exception) {
            $io->error(['Could not fetch or parse the page as expected', $exception->getMessage()]);
        }
        
        return 1;
    }
}
