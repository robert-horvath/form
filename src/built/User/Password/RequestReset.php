<?php
declare(strict_types = 1);
namespace RHo\Form\User\Password;

use RHo\UI\ { Email };
use RHo\Form\AbstractForm;

class RequestReset extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'email' => function ($x) { return Email::mandatory($x); }
        ]);
    }

    public function email(): string { return $this->in('email'); }
}