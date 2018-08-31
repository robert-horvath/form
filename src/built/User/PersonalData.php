<?php
declare(strict_types = 1);
namespace RHo\Form\User;

use RHo\UI\ { SemVer, Name };
use RHo\Form\AbstractProtectedForm;

class PersonalData extends AbstractProtectedForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'eula' => function ($x) { return SemVer::optional($x); },
            'firstname' => function ($x) { return Name::optional($x); }
        ]);
    }

    public function eulaVersion(): ?string { return $this->in('eula'); }

    public function firstName(): ?string { return $this->in('firstname'); }
}