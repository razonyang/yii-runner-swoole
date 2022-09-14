<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Swoole\Coroutine\Http\Server;

final class ServerFactory implements ServerFactoryInterface
{
    public function __construct(
        private string $host,
        private int $port = 9501,
    ) {
    }


    public function withHost(string $host): static
    {
        $new = clone $this;
        $new->host = $host;

        return $new;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function withPort(int $port): static
    {
        $new = clone $this;
        $new->port = $port;

        return $new;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function create(): Server
    {
        $srv = new Server($this->host, $this->port, false, true);

        return $srv;
    }
}
