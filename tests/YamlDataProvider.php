<?php
declare(strict_types = 1);
namespace RHo\Form\Test;

class YamlDataProvider implements \Iterator
{

    private $array;

    public static function validData(string $file): self
    {
        return new self($file, TRUE);
    }

    public static function invalidData(string $file): self
    {
        return new self($file, FALSE);
    }

    private function __construct(string $fileName, bool $validForms)
    {
        $array = yaml_parse_file(__DIR__ . '/data/' . $fileName);
        $this->array = $validForms ? $array['valid'] : $array['invalid'];
    }

    public function current()
    {
        return current($this->array);
    }

    public function next()
    {
        next($this->array);
    }

    public function key()
    {
        return key($this->array);
    }

    public function valid()
    {
        return key($this->array) !== NULL;
    }

    public function rewind()
    {
        reset($this->array);
    }
}
