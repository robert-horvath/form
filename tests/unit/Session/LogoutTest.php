<?php
declare(strict_types = 1);
namespace RHo\Form\Session;

use PHPUnit\Framework\TestCase;
use RHo\Form\Test\YamlDataProvider;

final class LogoutTest extends TestCase
{

    public function validFormDataProvider()
    {
        return YamlDataProvider::validData('logout.yaml');
    }

    public function invalidFormDataProvider()
    {
        return YamlDataProvider::invalidData('logout.yaml');
    }

    /**
     * @dataProvider validFormDataProvider
     */
    public function testValidForm(array $in, array $err, array $out): void
    {
        $form = new Logout($in);
        
        $this->assertTrue($form->isValid());
        $this->assertJsonStringEqualsJsonString(json_encode($err), json_encode($form));
        
        foreach ($out as $f => $v) {
            if (is_array($v))
                $this->iterateArray($form->$f(), $v);
            else
                $this->assertEquals($v, $form->$f());
        }
    }

    /**
     * @dataProvider invalidFormDataProvider
     */
    public function testInvalidForm(array $in, array $err): void
    {
        $form = new Logout($in);
        
        $this->assertFalse($form->isValid());
        $this->assertJsonStringEqualsJsonString(json_encode($err), json_encode($form));
    }

    private function iterateArray($g, array $arr)
    {
        foreach ($arr as $f => $v) {
            if (is_array($v))
                $this->iterateArray($g->$f(), $v);
            else {
                $ch = substr($f, 0, 1);
                if (strtolower($ch) === $ch)
                    $this->assertEquals($v, $g->$f());
                else
                    $this->assertEquals(unserialize($v), $g->$f());
            }
        }
    }
}