<?php
declare(strict_types = 1);
namespace RHoTest\Form;

ini_set('xdebug.var_display_max_depth', '10');

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{

    /** @var TemplateWithExamples */
    private $tmpl;

    private function tmpl()
    {
        if ($this->tmpl === NULL)
            $this->tmpl = TemplateWithExamples::buildFromYaml(__DIR__ . '/data/' . static::$yamlFile);
        return $this->tmpl;
    }

    public function formDataProvider()
    {
        return $this->tmpl()->iterator();
    }

    protected function tearDown()
    {
        if ($this->isUnitTesting())
            \Mockery::close();
    }

    /**
     * @dataProvider formDataProvider
     */
    public function testForms(array $in, array $out, array $err, array $mock, bool $isValid, bool $hasUnknownUI): void
    {
        $className = $this->tmpl()->class();
        if ($this->isUnitTesting())
            $this->createMockeryMocks($mock, $err);
        $form = new $className($in);
        
        $this->assertEquals($err, $form->jsonSerialize(), "### Form errors don't match");
        $this->assertJsonStringEqualsJsonString(json_encode($err), json_encode($form), "### JSON form errors don't match");
        $this->assertSame($isValid, $form->isValid(), '### Invalid form');
        $this->assertSame($hasUnknownUI, $form->hasUnknownFields(), '### Form has unknown fields');
        
        foreach ($this->tmpl()->methods() as $func) {
            $field = $this->tmpl()->fieldOfMethod($func);
            $value = $out[$func];
            if ($err[$field] === NULL) {
                if (is_object($value))
                    $this->assertEquals($value, $form->$func(), '### Invalid form data objects');
                else
                    $this->assertSame($value, $form->$func(), '### Invalid form data');
            } else
                $this->checkFormExceptionThrown($form, $func, $field);
        }
    }

    private function checkFormExceptionThrown($form, $func, $field)
    {
        try {
            $form->$func();
            $this->assertTrue(false, 'Must not execute this line');
        } catch (\LogicException $e) {
            $this->assertSame("Form field <$field> invalid.", $e->getMessage());
            $this->assertSame(0, $e->getCode());
        }
    }

    private function createMockeryMocks(array $mock, array $err)
    {
        foreach ($this->tmpl()->fields() as $field) {
            $externalMock = \Mockery::mock('overload:' . $this->tmpl()->classOfField($field));
            if ($err[$field] === NULL)
                $externalMock->shouldReceive('mandatory')
                    ->once()
                    ->andReturn($mock[$field]);
            else
                $externalMock->shouldReceive('mandatory')
                    ->once()
                    ->andThrow(\RHo\UIException\Exception::class, $err[$field]['txt'], $err[$field]['code']);
        }
    }

    private function isUnitTesting(): bool
    {
        return (count(array_intersect([
            '--testsuite',
            'Unit'
        ], $_SERVER['argv'])) == 2);
    }
}