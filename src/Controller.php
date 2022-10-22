<?php
declare(strict_types = 1);

namespace Application;

use Application\CardsDetailsSource\CardsDetailsSource;
use Application\CurrencyRatesSource\CurrencyRatesSourceFactory;
use Application\Reader\ReaderFactory;
use Application\Request\RequestFactory;

class Controller
{
    private Registry $registry;

    public function __construct()
    {
        $this->registry = Registry::instance();
    }

    public function init(): void
    {
        $request = RequestFactory::getRequest();
        $this->registry->setRequest($request);

        $configFilename = $this->registry->getRequest()->getProperty('config');
        $config = new Config($configFilename ?? 'config.ini');
        $this->registry->setConfig($config);
    }

    public function run(): void
    {
        /* get reader */
        $filename = $this->registry->getRequest()->getProperty('file');
        $reader = ReaderFactory::getReader($filename);

        /* get currencyRates */
        $currencyRatesSource = CurrencyRatesSourceFactory::getCurrencyRatesSource($this->registry->getConfig());

        /* get cards details source */
        $cardsDetailsSource = new CardsDetailsSource($this->registry->getConfig()->get('cards_details_source')['url']);

        /* create and run analyser */
        $transactionsAnalyser = new TransactionsAnalyser($this->registry->getConfig(), $reader, $cardsDetailsSource, $currencyRatesSource);
        $transactionsAnalyser->loadTransactions();
        $transactionsAnalyser->printTransactions();
    }
}
