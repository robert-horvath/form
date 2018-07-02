<?php
declare(strict_types = 1);
namespace RHo\Form;

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    use YmlDataProviderTrait;

    /**
     * @dataProvider validDataProvider
     */
    public function testValidForm(array $in, array $err, array $out): void
    {
        $form = new $this->className($in);
        $this->evalExceptionConstants($err);
        
        $this->assertTrue($form->isValid());
        $this->assertJsonStringEqualsJsonString(json_encode($err), json_encode($form));
        
        foreach ($out as $f => $v) {
            $ch = substr($v, 0, 1);
            if ($ch === 'O')
                $this->assertEquals(unserialize($v), $form->$f());
            else
                $this->assertSame(unserialize($v), $form->$f());
        }
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testInvalidForm(array $in, array $err): void
    {
        $form = new $this->className($in);
        $this->evalExceptionConstants($err);
        
        $this->assertFalse($form->isValid());
        $this->assertJsonStringEqualsJsonString(json_encode($err), json_encode($form));
    }

    private function evalExceptionConstants(array &$err): void
    {
        foreach ($err as $k => &$v)
            if ($v !== NULL)
                $v['code'] = constant($v['code']);
    }
}