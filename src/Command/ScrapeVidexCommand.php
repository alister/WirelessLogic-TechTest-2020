<?php
declare(strict_types=1);

namespace App\Command;

use App\Scrapers\VidexComesconnectedCom;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;

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
            ->addOption('allow-broken-ssl', '', InputOption::VALUE_NONE, 'Allow the TLS certificate to be ignored (not checked) [true|false]')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('url');

        if ($input->getOption('allow-broken-ssl')) {
            $options = ['verify_peer' => false]; // the test site is broken
        }
        // This would otherwise be an option into a factory to make the HttpClient  
        $httpBrowser = new HttpBrowser(HttpClient::create($options ?? []));

        try {
            $collectedData = $this->scraper->scrape($url, $httpBrowser);
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
