<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Application\Controller;

$controller = new Controller();
$controller->init();
$controller->run();


//$analiser = new TransactionsAnaliser();
//$analiser->loadTransactions($argv[1]);
//$analiser->printTransactions();

