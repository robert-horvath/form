<?php
declare(strict_types = 1);
namespace RHoTest\Form;

/**
 * The class reads the yaml configuration file to provide input data
 * and expected results for unit and integration tests.
 */
class TestTemplate extends Template
{

    /** @var array */
    private $examples;

    protected function __construct(array $cfg)
    {
        parent::__construct($cfg);
        $this->examples = $this->initExamples($cfg['examples']);
    }

    private function initExamples(array $arr): array
    {
        $examples = [];
        foreach ($arr as $example) {
            $arr = [
                'in' => $example['in'] ?? [], // might be partial
                'out' => $this->getFormOutputs($example['out'] ?? []),
                'err' => $this->getFormErrors($example['err'] ?? []),
                'mock' => $this->getMocks($example['mock'] ?? []) // might be partial
            ];
            $arr['valid'] = $this->isValidForm($arr['err']);
            $arr['unknownUI'] = $this->hasUnknownUI($arr['in']);
            $examples[] = $arr;
        }
        return $examples;
    }

    private function isIndexedArray(array $array): bool
    {
        return count(array_filter(array_keys($array), 'is_int')) == count($array);
    }

    private function evalExceptionConstants(array &$err): void
    {
        foreach ($err as &$value)
            if ($value !== NULL)
                $value['code'] = constant('RHo\\UIException\\Exception::' . $value['code']);
    }

    /**
     * Get all form output values
     *
     * @param array $out
     * @return array [ <func name> => <return value> ]
     */
    private function getFormOutputs(array $out): array
    {
        return array_map('unserialize', array_merge(array_fill_keys($this->methods(), "N;"), $out));
    }

    /**
     * Get list of objects to mock
     *
     * @param array $mocks
     * @return array [ <ui field> => <return value> ]
     */
    private function getMocks(array $mocks): array
    {
        $arr = [];
        foreach ($mocks as $field => $value)
            $arr[$field] = unserialize($value);
        return $arr;
    }

    private function getFormErrorsWithCodeConstStr(array $err): array
    {
        if ($err === [])
            return array_fill_keys($this->fields(), NULL);
        if ($this->isIndexedArray($err))
            return array_fill_keys($this->fields(), $err[0]);
        return array_merge($this->getFormErrorsWithCodeConstStr([]), $err);
    }

    /**
     * Get all error values
     *
     * @param array $err
     *            Partial or full error config data
     * @return array [ <ui field> => NULL | [ 'code' => <err code>, 'txt' => <err text> ] ]
     */
    private function getFormErrors(array $err): array
    {
        $err = $this->getFormErrorsWithCodeConstStr($err);
        $this->evalExceptionConstants($err);
        return $err;
    }

    private function isValidForm(array $err): bool
    {
        foreach ($err as $value)
            if ($value !== NULL)
                return false;
        return true;
    }

    private function hasUnknownUI(array $in): bool
    {
        return ! empty(array_diff(array_keys($in), $this->fields()));
    }

    /**
     * Convert this class to PhpUnitTest dataprovider format
     *
     * @return \ArrayObject
     */
    public function iterator(): \ArrayIterator
    {
        return (new \ArrayObject($this->examples))->getIterator();
    }
}