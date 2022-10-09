<?php

use PHPUnit\Framework\TestCase;
use App\TransactionsAnaliser;

class TransactionsAnaliserTest extends TestCase
{
    /**
     * Can't quite understand how to test methods with another classes inside.
     * The only option I see, is injection of all dependencies from outside (pass already created objects as arguments).
     * But it will make the user code very difficult and sophisticated. So will need a Fabric to create objects, and
     * this fabric will not have a tests.
     */

}