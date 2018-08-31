<?php
namespace RHo\Form;

interface FormInterface
{

    function hasUnknownFields(): bool;

    function isValid(): bool;
}
