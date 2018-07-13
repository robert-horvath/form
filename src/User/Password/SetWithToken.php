<?php
declare(strict_types = 1);
namespace RHo\Form\User\Password;

use RHo\Form\AbstractProtectedForm;
use RHo\UI\Password;

class SetWithToken extends AbstractProtectedForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'psswrd' => function ($x) {
                return Password::mandatory($x);
            }
        ]);
    }

    public function newPassword(): string
    {
        return $this->in['psswrd'];
    }
}
