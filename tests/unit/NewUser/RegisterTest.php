<?php
declare(strict_types = 1);
namespace RHo\Form\NewUser;

use RHo\Form\AbstractTestCase;

final class RegisterTest extends AbstractTestCase
{

    protected function ymlFileName(): string
    {
        return 'new-user/register.yml';
    }
}