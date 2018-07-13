[![Build Status](https://travis-ci.org/robert-horvath/form.svg?branch=master)](https://travis-ci.org/robert-horvath/form)
[![Code Coverage](https://codecov.io/gh/robert-horvath/form/branch/master/graph/badge.svg)](https://codecov.io/gh/robert-horvath/form)
[![Latest Stable Version](https://img.shields.io/packagist/v/robert/form.svg)](https://packagist.org/packages/robert/form)

# Form
User Input Forms

## Example usage
```php
namespace RHo;

function foo(array $ui)
{
    $form = new Form\NewUser\Registration($ui);
    echo (sprintf("Is valid: %s\n", $form->isValid() ? 'Yes' : 'No'));
    echo (sprintf("Has extra field(s): %s\n", $form->hasExtraFields() ? 'Yes' : 'No'));
    echo json_encode($form, JSON_PRETTY_PRINT);
    
    if ($form->isValid())
        var_dump($form->firstName(), $form->email(), $form->password(), $form->eulaVersion());
}
```

### 1. Example usage with valid data
```php
RHo\foo([
    'email' => 'email@addr.es',
    'psswrd' => 'Secret1',
    'eula' => '1.0.0',
    'firstname' => 'Peter'
]);
```
#### 1.1. The above example outputs
```
Is valid: Yes
Has extra field(s): No
{
    "firstname": null,
    "email": null,
    "psswrd": null,
    "eula": null
}
string(5) "Peter"
string(13) "email@addr.es"
string(7) "Secret1"
string(5) "1.0.0"
```
### 2. Example usage with valid data + extra field
```php
RHo\foo([
    'email' => 'email@addr.es',
    'psswrd' => 'Secret1',
    'eula' => '1.0.0',
    'firstname' => 'Peter',
    'extra' => true
]);
```
#### 2.1. The above example outputs
```
Is valid: Yes
Has extra field(s): Yes
{
    "firstname": null,
    "email": null,
    "psswrd": null,
    "eula": null
}
string(5) "Peter"
string(13) "email@addr.es"
string(7) "Secret1"
string(5) "1.0.0"
```
### 3. Example usage with invalid data
```php
RHo\foo([
    'email' => 'email.addr.es',
    'psswrd' => NULL,
    'firstname' => 'Peter?'
]);
```
#### 3.1 The above example outputs
```
Is valid: No
Has extra field(s): No
{
    "firstname": {
        "code": 2,
        "txt": "Pattern does not match given subject"
    },
    "email": {
        "code": 2,
        "txt": "Invalid e-mail address"
    },
    "psswrd": {
        "code": 1,
        "txt": "Mandatory value missing"
    },
    "eula": {
        "code": 1,
        "txt": "Mandatory value missing"
    }
}
```
### 4. Example usage with invalid data + extra field
```php
RHo\foo([
    'email' => 'email.addr.es',
    'psswrd' => NULL,
    'firstname' => 'Peter?',
    'extra' => []
]);
```
#### 4.1 The above example outputs
```
Is valid: No
Has extra field(s): Yes
{
    "firstname": {
        "code": 2,
        "txt": "Pattern does not match given subject"
    },
    "email": {
        "code": 2,
        "txt": "Invalid e-mail address"
    },
    "psswrd": {
        "code": 1,
        "txt": "Mandatory value missing"
    },
    "eula": {
        "code": 1,
        "txt": "Mandatory value missing"
    }
}
```