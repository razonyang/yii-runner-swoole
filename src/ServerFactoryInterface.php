<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Swoole\Coroutine\Http\Server;

interface ServerFactoryInterface
{
    /**
     * Create a server instance.
     *
     * @return Server
     */
    public function create(): Server;
}
