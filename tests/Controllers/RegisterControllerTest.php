<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use Portal\Controllers\RegisterController;
use Slim\Views\PhpRenderer;

class RegisterControllerTest extends TestCase
{
    public function testConstruct()
    {
        $stub = $this->createMock(PhpRenderer::class);
        $password = 'password';

        $case = new RegisterController($stub, $password);
        $expected = RegisterController::class;
        $this->assertInstanceOf($expected, $case);
    }
}
