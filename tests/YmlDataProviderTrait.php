<?php
declare(strict_types = 1);
namespace RHo\Form;

use ArrayObject;

trait YmlDataProviderTrait
{

    /** @var string */
    protected $className;

    /** @var string */
    protected $mockPregMatch;

    /** @var array */
    private $ymlTestData;

    protected function setUp()
    {
        if ($this->className === NULL)
            $this->className = $this->ymlTestData($this->ymlFileName(), 'class');
    }

    protected function ymlTestData(string $fileName, string $key)
    {
        if ($this->ymlTestData === NULL)
            $this->ymlTestData = yaml_parse_file(__DIR__ . '/data/' . $fileName);
        return $this->ymlTestData[$key] ?? NULL;
    }

    abstract protected function ymlFileName(): string;

    public function validDataProvider()
    {
        return (new ArrayObject($this->ymlTestData($this->ymlFileName(), 'valid')))->getIterator();
    }

    public function invalidDataProvider()
    {
        return (new ArrayObject($this->ymlTestData($this->ymlFileName(), 'invalid')))->getIterator();
    }
}
