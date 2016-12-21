<?php

use App\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    function testIfValid()
    {
        $user = User::create('Rémi', 'Andrieux', '20', 'contact@remiandrieux.fr');
        $this->assertTrue($user->isValid());
    }

    function testIfNotValid()
    {
        $user = User::create('Rémi', 'Andrieux', '12', 'contact@remiandrieux.fr');
        $this->assertFalse($user->isValid());
    }
}
