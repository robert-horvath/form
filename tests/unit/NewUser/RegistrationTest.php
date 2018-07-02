<?php
declare(strict_types = 1);
namespace RHo\Form\NewUser;

use RHo\Form\AbstractTestCase;

final class RegistrationTest extends AbstractTestCase
{

    protected function ymlFileName(): string
    {
        return 'new-user/registration.yml';
    }
}