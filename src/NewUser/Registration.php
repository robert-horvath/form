<?php
declare(strict_types = 1);
namespace RHo\Form\NewUser;

use RHo\Form\AbstractForm;
use RHo\UI\ {
    Name,
    Email,
    SemVer,
    Password
};

class Registration extends AbstractForm
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
            },
            'eula' => function ($x) {
                return SemVer::mandatory($x);
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

    public function eulaVersion(): string
    {
        return $this->in['eula'];
    }
}
