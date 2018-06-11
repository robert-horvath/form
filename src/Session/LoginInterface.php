<?php
namespace RHo\Form\Session;

interface LoginInterface
{

    function email(): string;

    function password(): string;
}