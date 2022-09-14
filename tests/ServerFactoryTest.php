<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole\Test;

use PHPUnit\Framework\TestCase;
use RazonYang\Yii\Runner\Swoole\ServerFactory;

class ServerFactoryTest extends TestCase
{
    public function withProvider(): array
    {
        return [
            ['0.0.0.0', 80],
            ['127.0.0.1', 8080],
            ['localhost', 9501],
            ['example.com', 9502],
        ];
    }

    /**
     * @dataProvider withProvider
     */
    public function testWith(string $host, int $port): void
    {
        $factory = new ServerFactory('127.0.0.1');
        $this->assertSame('127.0.0.1', $factory->getHost());
        $this->assertSame(9501, $factory->getPort());

        $new = $factory->withHost($host);
        $this->assertSame($host, $new->getHost());

        $new = $factory->withPort($port);
        $this->assertSame($port, $new->getPort());
    }
}
