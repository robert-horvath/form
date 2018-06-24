<?php
declare(strict_types = 1);
namespace RHo\Form\Session;

use PHPUnit\Framework\TestCase;
use RHo\Form\Test\YamlDataProvider;

final class LoginTest extends TestCase
{

    public function validFormDataProvider()
    {
        return YamlDataProvider::validData('login.yaml');
    }

    public function invalidFormDataProvider()
    {
        return YamlDataProvider::invalidData('login.yaml');
    }

    /**
     * @dataProvider validFormDataProvider
     */
    public function testValidForm(array $in, array $err, array $out): void
    {
        $form = new Login($in);
        
        $this->assertTrue($form->isValid());
        $this->assertJsonStringEqualsJsonString(json_encode($err), json_encode($form));
        
        foreach ($out as $f => $v)
            $this->assertEquals($v, $form->$f());
    }

    /**
     * @dataProvider invalidFormDataProvider
     */
    public function testInvalidForm(array $in, array $err): void
    {
        $form = new Login($in);
        
        $this->assertFalse($form->isValid());
        $this->assertJsonStringEqualsJsonString(json_encode($err), json_encode($form));
    }
}