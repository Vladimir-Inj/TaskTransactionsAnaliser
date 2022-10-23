<?php
declare(strict_types = 1);

namespace Application;

use Application\CardsDetailsSource\CardsDetailsSource;
use Application\CurrencyRatesSource\CurrencyRatesSourceFactory;
use Application\Reader\ReaderFactory;
use Application\Request\AbstractRequest;
use Application\Request\RequestFactory;

class Controller
{
    private ?AbstractRequest $request = null;
    private ?Config $config = null;

    public function init(): void
    {
        $this->request = RequestFactory::getRequest();

        $configFilename = $this->request->getProperty('config');
        $this->config = new Config($configFilename ?? 'public/config.ini');
    }

    public function run(): void
    {
        /* get reader */
        $filename = $this->request->getProperty('file');
        $reader = ReaderFactory::getReader($filename);

        /* get currencyRates */
        $currencyRatesSource = CurrencyRatesSourceFactory::getCurrencyRatesSource($this->config);

        /* get cards details source */
        $cardsDetailsSource = new CardsDetailsSource($this->config->get('cards_details_source')['url']);

        /* create and run analyser */
        $transactionsAnalyser = new TransactionsAnalyser($this->config, $reader, $cardsDetailsSource, $currencyRatesSource);
        $transactionsAnalyser->loadTransactions();
        $transactionsAnalyser->printTransactions();
    }
}
