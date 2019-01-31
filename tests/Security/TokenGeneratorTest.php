<?php
/**
 * Created by PhpStorm.
 * User: taras
 * Date: 31.01.19
 * Time: 2:24
 */

namespace App\Tests\Security;


use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testTokenGeneration()
    {
        $tokenGen = new TokenGenerator();
        $token = $tokenGen->getRandomSecureToken(30);

        $this->assertEquals(30, strlen($token));
        $this->assertTrue(ctype_alnum($token), 'Token contains incorrect characters');
    }
}