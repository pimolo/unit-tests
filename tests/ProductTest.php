<?php

use App\Product;
use App\User;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    function testIfValid()
    {
        $user = $this->createMock(User::class);
        $user
            ->method('isValid')
            ->willReturn(true)
        ;

        $product = Product::create('foo', Product::ACTIVATED, $user);
        $this->assertTrue($product->isValid());
    }

    function testIfNotValid()
    {
        $user = $this->createMock(User::class);
        $user
            ->method('isValid')
            ->willReturn(false)
        ;

        $product = Product::create('bar', Product::ACTIVATED, $user);
        $this->assertFalse($product->isValid());
    }
}
