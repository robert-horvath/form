<?php
declare(strict_types = 1);
namespace RHo\Form\User\Email;

use RHo\Form\AbstractProtectedForm;
use RHo\UI\Email;

class RequestChange extends AbstractProtectedForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'email' => function ($x) {
                return Email::mandatory($x);
            }
        ]);
    }

    public function newEmail(): string
    {
        return $this->in['email'];
    }
}
