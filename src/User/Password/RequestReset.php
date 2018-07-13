<?php
declare(strict_types = 1);
namespace RHo\Form\User\Password;

use RHo\Form\AbstractForm;
use RHo\UI\ {
    Email
};

class RequestReset extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'email' => function ($x) {
                return Email::mandatory($x);
            }
        ]);
    }

    public function email(): string
    {
        return $this->in['email'];
    }
}
