<?php
declare(strict_types = 1);
namespace RHo\Form;

use RHo\UI\ {
    AlphaNumToken,
    Authorization
};

abstract class AbstractProtectedForm extends AbstractForm
{

    public function __construct(array $ui, array $fields = [])
    {
        parent::__construct($ui, array_merge($fields, [
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
        return $this->in('userid');
    }

    public function token(): string
    {
        return $this->in('authorization')->token;
    }

    public function dateTime(): \DateTime
    {
        return $this->in('authorization')->dateTime;
    }
}