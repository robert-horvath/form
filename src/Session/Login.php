<?php
declare(strict_types = 1);
namespace RHo\Form\Session;

use RHo\Form\AbstractForm;
use RHo\UI\ {
    Email,
    Password
};

class Login extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'email' => function ($x) {
                return Email::mandatory($x);
            },
            'psswrd' => function ($x) {
                return Password::mandatory($x);
            }
        ]);
    }

    public function email(): string
    {
        return $this->in['email'];
    }

    public function password(): string
    {
        return $this->in['psswrd'];
    }
}
