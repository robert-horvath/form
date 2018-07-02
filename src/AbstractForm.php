<?php
declare(strict_types = 1);
namespace RHo\Form;

use RHo\UI\Exception;

abstract class AbstractForm implements \JsonSerializable
{

    /** @var array */
    protected $in;

    /** @var bool */
    protected $valid;

    public function __construct(array $ui, array $fields)
    {
        $this->valid = $this->validateFields($ui, $fields);
    }

    private function popFieldFromUIArray(array &$ui, string $key)
    {
        $retVal = $ui[$key] ?? NULL;
        unset($ui[$key]);
        return $retVal;
    }

    private function validateFields(array $ui, array $fields): bool
    {
        $valid = TRUE;
        foreach ($fields as $key => $f) {
            try {
                $this->in[$key] = $f($this->popFieldFromUIArray($ui, $key));
            } catch (Exception $e) {
                $this->in[$key] = $e;
                $valid = FALSE;
            }
        }
        return $valid && empty($ui);
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function jsonSerialize(): array
    {
        $json = [];
        foreach ($this->in as $k => $v)
            $json[$k] = $this->getException($v);
        return $json;
    }

    private function getException($e): ?array
    {
        return is_a($e, Exception::class) ? [
            'code' => $e->getCode(),
            'txt' => $e->getMessage()
        ] : NULL;
    }
}
