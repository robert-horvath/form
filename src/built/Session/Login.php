<?php
declare(strict_types = 1);
namespace RHo\Form\Session;

use RHo\UI\ { Password, Email };
use RHo\Form\AbstractForm;

class Login extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'psswrd' => function ($x) { return Password::mandatory($x); },
            'email' => function ($x) { return Email::mandatory($x); }
        ]);
    }

    public function password(): string { return $this->in('psswrd'); }

    public function email(): string { return $this->in('email'); }
}