<?php
declare(strict_types = 1);
namespace RHo\Form\User;

use RHo\Form\AbstractProtectedForm;
use RHo\UI\ {
    Name,
    SemVer
};

class PersonalData extends AbstractProtectedForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'firstname' => function ($x) {
                return Name::optional($x);
            },
            'eula' => function ($x) {
                return SemVer::optional($x);
            }
        ]);
    }

    public function firstName(): ?string
    {
        return $this->in['firstname'];
    }

    public function eulaVersion(): ?string
    {
        return $this->in['eula'];
    }
}
