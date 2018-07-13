<?php
declare(strict_types = 1);
namespace RHo\Form;

use RHo\UI\ {
    AlphaNumToken,
    Authorization
};

class AddressForm extends AbstractForm
{

    public function __construct(array $ui, array $form = [])
    {
        parent::__construct($ui, array_merge($form, [
            'userid' => function ($x) {
                return AlphaNumToken::mandatory($x, 32);
            },
            'authorization' => function ($x) {
                return Authorization::mandatory($x);
            }
        ]));
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
