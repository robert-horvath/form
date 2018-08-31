<?php
declare(strict_types = 1);
namespace RHo\Form\Session;

use RHo\UI\ { AlphaNumToken, Authorization };
use RHo\Form\AbstractForm;

class Logout extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'session' => function ($x) { return AlphaNumToken::mandatory($x,32); },
            'authorization' => function ($x) { return Authorization::mandatory($x); }
        ]);
    }

    public function sessionID(): string { return $this->in('session'); }

    public function token(): string { return $this->in('authorization')->token; }

    public function createdAt(): \DateTime { return $this->in('authorization')->dateTime; }
}