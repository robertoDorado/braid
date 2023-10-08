<?php

namespace Source\Domain\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Source\Domain\Model\User;

/**
 * UserTest Source\Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class UserTest extends TestCase
{
    /** @var User Objeto a ser testado */
    private User $user;

    public function testFailLoginA()
    {
        $this->user = new User();
        $this->assertNull($this->user->login('percyDorado', '', 'Rob@182829', 'businessman'));
    }

    public function testFailLoginB()
    {
        $this->user = new User();
        $this->assertNull($this->user->login('', 'percy@gmail.com', 'Rob@182829', 'businessman'));
    }

    public function testFailLoginC()
    {
        $this->user = new User();
        $this->assertNull($this->user->login('', 'robertodorado7@gmail.com', '-----', 'businessman'));
    }

    public function testFailLoginD()
    {
        $this->user = new User();
        $this->assertNull($this->user->login('', 'robertodorado7@gmail.com', '-----', 'designer'));
    }

    public function testRequestRecoverPassword()
    {
        $this->user = new User();
        $this->assertFalse($this->user->requestRecoverPassword('userName', 'test@mail.com'));
    }

    public function testRecoverPasswordA()
    {
        $this->user = new User();
        $this->assertFalse($this->user->recoverPassword('userName', 'test@gmail.com', 'myPassword', 'myPassword'));
    }

    public function testRecoverPasswordB()
    {
        $this->user = new User();
        $this->assertFalse($this->user->recoverPassword('robertoDorado', '', 'Rob@11111', 'Rob@22222'));
    }

    public function testgetRecoverPasswordByHashA()
    {
        $this->user = new User();
        $reflection = new ReflectionClass('Source\Domain\Model\User');

        $privateMethod = $reflection->getMethod('getRecoverPasswordByHash');
        $privateMethod->setAccessible(true);

        $result = $privateMethod->invoke($this->user, '', 'robertodorado7@gmail.comm');
        $this->assertNull($result);
    }

    public function testgetRecoverPasswordByHashD()
    {
        $this->user = new User();
        $reflection = new ReflectionClass('Source\Domain\Model\User');

        $privateMethod = $reflection->getMethod('getRecoverPasswordByHash');
        $privateMethod->setAccessible(true);

        $result = $privateMethod->invoke($this->user, 'robertoDoradoo', '');
        $this->assertNull($result);
    }

    public function testValidateUserTypeA()
    {
        $this->user = new User();
        $reflection = new ReflectionClass('Source\Domain\Model\User');

        $privateMethod = $reflection->getMethod('validateUserType');
        $privateMethod->setAccessible(true);

        $result = $privateMethod->invoke($this->user, 'businessman');
        $this->assertTrue($result);
    }

    public function testValidateUserTypeB()
    {
        $this->user = new User();
        $reflection = new ReflectionClass('Source\Domain\Model\User');

        $privateMethod = $reflection->getMethod('validateUserType');
        $privateMethod->setAccessible(true);

        $result = $privateMethod->invoke($this->user, 'designer');
        $this->assertTrue($result);
    }

    public function testValidateUserTypeC()
    {
        $this->user = new User();
        $reflection = new ReflectionClass('Source\Domain\Model\User');

        $privateMethod = $reflection->getMethod('validateUserType');
        $privateMethod->setAccessible(true);

        $result = $privateMethod->invoke($this->user, '');
        $this->assertFalse($result);
    }

    public function testCheckParamsNotEmptyA()
    {
        $this->user = new User();
        $reflection = new ReflectionClass('Source\Domain\Model\User');

        $privateMethod = $reflection->getMethod('checkParamsNotEmpty');
        $privateMethod->setAccessible(true);

        $result = $privateMethod->invoke($this->user, 'teste1', 'teste2', 'teste3', 'teste4');
        $this->assertTrue($result);
    }

    public function testCheckParamsNotEmptyB()
    {
        $this->user = new User();
        $reflection = new ReflectionClass('Source\Domain\Model\User');

        $privateMethod = $reflection->getMethod('checkParamsNotEmpty');
        $privateMethod->setAccessible(true);

        $result = $privateMethod->invoke($this->user, 'teste1', 'teste2', '', 'teste4');
        $this->assertFalse($result);
    }
}
