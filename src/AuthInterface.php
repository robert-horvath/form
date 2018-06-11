<?php
namespace RHo\Form;

use DateTime;

interface AuthInterface
{

    function id(): string;

    function createdAt(): DateTime;
}