<?php
declare(strict_types = 1);
namespace RHo\Form\Session;

use RHo\Form\AbstractTestCase;

final class LoginTest extends AbstractTestCase
{

    protected function ymlFileName(): string
    {
        return 'session/login.yml';
    }
}