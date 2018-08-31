<?php
declare(strict_types = 1);
namespace RHo\Form\User\Password;

use RHo\UI\ { Password };
use RHo\Form\AbstractForm;

class SetWithToken extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'psswrd' => function ($x) { return Password::mandatory($x); }
        ]);
    }

    public function newPassword(): string { return $this->in('psswrd'); }
}