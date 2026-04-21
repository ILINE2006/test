<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class NameValidator extends AbstractValidator
{
    protected string $message = 'Поле :field может содержать только буквы, пробелы и дефис';

    public function rule(): bool
    {
        if (empty($this->value)) {
            return false;
        }

        return (bool) preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $this->value);
    }
}