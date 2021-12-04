<?php

declare(strict_types=1);

namespace App\Logs\Domain;

final class Log
{
    public function __construct(
        private LogHour $hour,
        private LogMessage $message,
    ) {
    }

    public static function create(
        \DateTime $hour,
        string $message,
    ) {
        return new Log(
            LogHour::create($hour),
            LogMessage::create($message)
        );
    }

    public function hour(): LogHour
    {
        return $this->hour;
    }

    public function message(): LogMessage
    {
        return $this->message;
    }
}
