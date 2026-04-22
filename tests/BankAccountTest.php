<?php

use PHPUnit\Framework\TestCase;

class BankAccountTest extends TestCase
{
    public function testDepot(): void
    {
        $compte = new BankAccount("Alice", 100);
        $compte->deposit(50);
        $this->assertEquals(150, $compte->getBalance());
    }
}