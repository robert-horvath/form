<?php
declare(strict_types = 1);
namespace RHo\Form\NewUser;

use RHo\Form\AbstractForm;
use RHo\UI\ {
    AlphaNumToken,
    Authorization
};

class Activation extends AbstractForm
{

    public function __construct(array $ui)
    {
        parent::__construct($ui, [
            'userid' => function ($x) {
                return AlphaNumToken::mandatory($x, 32);
            },
            'authorization' => function ($x) {
                return Authorization::mandatory($x);
            }
        ]);
    }

    public function userID(): string
    {
        return $this->in['userid'];
    }

    public function token(): string
    {
        return $this->in['authorization']->token;
    }

    public function createdAt(): \DateTime
    {
        return $this->in['authorization']->dateTime;
    }
}
