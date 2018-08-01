<?php
declare(strict_types = 1);
namespace RHo\Form;

final class FormError
{

    /** @var int */
    private $code;

    /** @var string */
    private $message;

    public function __construct(int $code, string $msg)
    {
        $this->code = $code;
        $this->message = $msg;
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'txt' => $this->message
        ];
    }
}
