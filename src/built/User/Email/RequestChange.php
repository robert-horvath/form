<?php
declare(strict_types = 1);
namespace RHo\Form\User\Email;

use RHo\UI\ { Email };
use RHo\Form\AbstractProtectedForm;

class RequestChange extends AbstractProtectedForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'new_email' => function ($x) { return Email::mandatory($x); }
        ]);
    }

    public function newEmail(): string { return $this->in('new_email'); }
}