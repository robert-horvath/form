<?php
namespace RHo\Form;

require_once 'vendor/autoload.php';

$logoutUI = [
    'session' => 'CiKNNxaUicGxkewwvFkjKloqhERIVbxZ',
    'authorization' => 'Bearer zotgdEfAlqSHTB583bOzZzvhXQehAokXxaYDzpFDzxlELBYXOEIWltKRskWCLbQn~Wed.23-May-2018_14/18/57.352896_GMT'
];

try {
    $form = new Session\Logout($logoutUI);
    var_dump($form->sessionID(), $form->token(), $form->createdAt());
} catch (\RHo\UI\Exception $e) {
    var_dump($e->getMessage(), $e->getCode());
}

var_dump(serialize('jndoj3pR5I51fAfASQEEo6xF4HiYMhjd'));