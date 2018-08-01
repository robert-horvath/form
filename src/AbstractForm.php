<?php
declare(strict_types = 1);
namespace RHo\Form;

use RHo\UIException\Exception;

abstract class AbstractForm implements \JsonSerializable
{

    /** @var array */
    private $in;

    /** @var bool */
    private $valid;

    /** @var bool */
    private $unknownFields;

    public function __construct(array $ui, array $fields)
    {
        $this->valid = $this->validateFields($ui, $fields);
        $this->unknownFields = ! empty($ui);
    }

    private function popFieldFromUIArray(array &$ui, string $key)
    {
        $retVal = $ui[$key] ?? NULL;
        unset($ui[$key]);
        return $retVal;
    }

    private function validateFields(array &$ui, array $fields): bool
    {
        $valid = TRUE;
        foreach ($fields as $key => $f) {
            try {
                $this->in[$key] = $f($this->popFieldFromUIArray($ui, $key));
            } catch (Exception $e) {
                $this->in[$key] = new FormError($e->getCode(), $e->getMessage());
                $valid = FALSE;
            }
        }
        return $valid;
    }

    public function hasUnknownFields(): bool
    {
        return $this->unknownFields;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    protected function in(string $key)
    {
        if (is_a($this->in[$key], FormError::class))
            throw new \LogicException("Form field <$key> invalid.");
        return $this->in[$key];
    }

    public function jsonSerialize(): array
    {
        $json = [];
        foreach ($this->in as $k => $v)
            $json[$k] = $this->getError($v);
        return $json;
    }

    private function getError($e): ?array
    {
        return is_a($e, FormError::class) ? $e->toArray() : NULL;
    }
}
