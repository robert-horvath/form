<?php
declare(strict_types = 1);
namespace RHo\Form\Session;

use RHo\Form\AbstractTestCase;

final class LogoutTest extends AbstractTestCase
{

    protected function ymlFileName(): string
    {
        return 'session/logout.yml';
    }
}