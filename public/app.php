<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\TransactionsAnaliser;

$analiser = new TransactionsAnaliser();
$analiser->loadTransactions($argv[1]);
$analiser->printTransactions();

