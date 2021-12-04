<?php

declare(strict_types=1);

namespace App\Logs\Domain;

use App\Shared\Domain\ValueObject\StringValueObject;

final class LogMessage extends StringValueObject
{
    public function __construct(protected string $value)
    {
        parent::__construct($this->value);
    }

    public static function create(string $value): LogMessage
    {
        return new LogMessage($value);
    }
}
