<?php

declare(strict_types=1);

namespace App\Tests\Logs\Domain;

use App\Logs\Domain\Log;
use PHPUnit\Framework\TestCase;

final class LogTest extends TestCase
{
    /**
     * @test
     */
    public function adNew(): void
    {
        $log = Log::create(
            new \DateTime('now'),
            'Test'
        );

        $this->assertInstanceOf(Log::class, $log);
    }
}
