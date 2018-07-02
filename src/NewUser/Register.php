<?php
declare(strict_types = 1);
namespace RHo\Form\NewUser;

use RHo\Form\AbstractForm;
use RHo\UI\ {
    Name,
    Email,
    Password
};

class Register extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'firstname' => function ($x) {
                return Name::mandatory($x);
            },
            'email' => function ($x) {
                return Email::mandatory($x);
            },
            'psswrd' => function ($x) {
                return Password::mandatory($x);
            }
        ]);
    }

    public function firstName(): string
    {
        return $this->in['firstname'];
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
