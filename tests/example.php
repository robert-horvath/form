<?php
namespace RHo {

require_once 'vendor/autoload.php';

// $logoutUI = [
// 'session' => 'CiKNNxaUicGxkewwvFkjKloqhERIVbxZ',
// 'authorization' => 'Bearer zotgdEfAlqSHTB583bOzZzvhXQehAokXxaYDzpFDzxlELBYXOEIWltKRskWCLbQn~Wed.23-May-2018_14/18/57.352896_GMT'
// ];

// try {
// $form = new Session\Logout($logoutUI);
// var_dump($form->sessionID(), $form->token(), $form->createdAt());
// } catch (\RHo\UI\Exception $e) {
// var_dump($e->getMessage(), $e->getCode());
// }

// var_dump(serialize('jndoj3pR5I51fAfASQEEo6xF4HiYMhjd'));


function foo(array $ui)
{
    $form = new Form\NewUser\Registration($ui);
    echo (sprintf("Is valid: %s\n", $form->isValid() ? 'Yes' : 'No'));
    echo (sprintf("Has extra field(s): %s\n", $form->hasExtraFields() ? 'Yes' : 'No'));
    
    if ($form->isValid())
        var_dump($form->firstName(), $form->email(), $form->password(), $form->eulaVersion());
    else
        echo json_encode($form, JSON_PRETTY_PRINT);
}

}

namespace {
    
    
    RHo\foo([
        'email' => 'email.addr.es',
        'psswrd' => NULL,
        'firstname' => 'Peter?',
        'extra' => []
    ]);
    
}