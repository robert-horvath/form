<?php
declare(strict_types = 1);
namespace RHo\Form\NewUser;

use RHo\UI\ { Password, SemVer, Email, Name };
use RHo\Form\AbstractForm;

class Registration extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'psswrd' => function ($x) { return Password::mandatory($x); },
            'eula' => function ($x) { return SemVer::mandatory($x); },
            'email' => function ($x) { return Email::mandatory($x); },
            'firstname' => function ($x) { return Name::mandatory($x); }
        ]);
    }

    public function password(): string { return $this->in('psswrd'); }

    public function eulaVersion(): string { return $this->in('eula'); }

    public function email(): string { return $this->in('email'); }

    public function firstName(): string { return $this->in('firstname'); }
}