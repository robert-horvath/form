<?php
declare(strict_types = 1);
namespace RHo\FormTest;

class Template
{

    /** @var string */
    private $class;

    /** @var array */
    private $fields;

    public static function buildFromYaml(string $filePath): self
    {
        $yaml = yaml_parse_file($filePath);
        return new static($yaml);
    }

    protected function __construct(array $cfg)
    {
        $this->class = 'RHo\\Form\\' . key($cfg['form']);
        $this->fields = $this->initFields(current($cfg['form']));
    }

    /**
     * Get qualified class name of form
     *
     * @return string The qualified class name of form
     */
    public function class(): string
    {
        return $this->class;
    }

    /**
     * Get all form input field names
     *
     * @return array Indexed array of form's input fields
     */
    public function fields(): array
    {
        return array_keys($this->fields);
    }

    /**
     * Get class name of form field
     *
     * @param string $name
     *            Field name
     * @return string Class name
     */
    public function classOfField(string $name): string
    {
        return $this->fields[$name]->class;
    }

    /**
     * Get all form getter access method names
     *
     * @return array Indexed array of form's getter functions (methods).
     */
    public function methods(): array
    {
        $arr = [];
        foreach ($this->fields as $o)
            foreach ($o->methods as $func)
                $arr[] = $func;
        return $arr;
    }

    /**
     * Get form field name by function (class method) name
     *
     * @param string $func
     *            Search this function (class method)
     * @return string Field name
     */
    public function fieldOfMethod(string $func): string
    {
        foreach ($this->fields as $ui => $o) {
            foreach ($o->methods as $f)
                if ($f === $func)
                    return $ui;
        }
        throw new \LogicException("Class method <$func> not found");
    }

    /**
     * Init form fields
     *
     * @param array $fields
     *            Input fields
     * @return array [ <field> => stdClass { $class => <ui class>, $methods => [ <func> => <return type> ] } ]
     */
    private function initFields(array $fields): array
    {
        $uiFields = [];
        foreach ($fields as $field => $value)
            $uiFields[$field] = (object) [
                // Qualified class name of form's field
                'class' => 'RHo\\UI\\' . key($value),
                // Form's method(s) to access the UI field
                // [ <func name> => <return type> ]
                'methods' => current($value)
            ];
        return $uiFields;
    }
}   