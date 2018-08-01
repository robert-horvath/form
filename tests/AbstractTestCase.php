<?php
declare(strict_types = 1);
namespace RHoTest\Form;

use PHPUnit\Framework\TestCase;
use Mockery as m;
use RHoTest;
ini_set('xdebug.var_display_max_depth', '10');

abstract class AbstractTestCase extends TestCase
{

    /** @var TestTemplate */
    private $tt;

    private function tmpl()
    {
        if ($this->tt === NULL)
            $this->tt = TestTemplate::buildFromYaml(__DIR__ . '/data/' . static::$yamlFile);
        return $this->tt;
    }

    public function formDataProvider()
    {
        return $this->tmpl()->iterator();
    }

    protected function tearDown()
    {
        m::close();
    }

    /**
     * @dataProvider formDataProvider
     */
    public function testForms(array $in, array $out, array $err, array $mock, bool $isValid, bool $hasUnknownUI): void
    {
        $className = $this->tmpl()->class();
        if (is_subclass_of($this, RHoTest\Form\AbstractUnitTestCase::class))
            $this->createMockeryMocks($mock, $err);
        $form = new $className($in);
        
        // var_dump($form->jsonSerialize());
        
        $this->assertEquals($err, $form->jsonSerialize(), "### Form errors don't match");
        $this->assertJsonStringEqualsJsonString(json_encode($err), json_encode($form), "### JSON form errors don't match");
        $this->assertSame($isValid, $form->isValid(), '### Invalid form');
        $this->assertSame($hasUnknownUI, $form->hasUnknownFields(), '### Form has unknown fields');
        
        foreach ($this->tt->methods() as $func) {
            $field = $this->tt->fieldOfMethod($func);
            $value = $out[$func];
            if ($err[$field] === NULL) {
                if (is_object($value))
                    $this->assertEquals($value, $form->$func(), '### Invalid form data objects');
                else
                    $this->assertSame($value, $form->$func(), '### Invalid form data');
            } else
                $this->checkFormException($form, $func, $field);
        }
    }

    private function checkFormException($form, $func, $field)
    {
        try {
            $form->$func();
        } catch (\LogicException $e) {
            $this->assertSame("Form field <$field> invalid.", $e->getMessage());
            $this->assertSame(0, $e->getCode());
        }
    }

    private function createMockeryMocks(array $mock, array $err)
    {
        foreach ($this->tt->fields() as $field) {
            $externalMock = m::mock('overload:' . $this->tt->classOfField($field));
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
}