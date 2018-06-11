<?php
namespace RHo\Form\Session;

use RHo\Form\AuthInterface;

interface LogoutInterface
{

    function session(): AuthInterface;
}