<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Swoole\Http\Response;

final class EmitterFactory implements EmitterFactoryInterface
{
    public function create(Response $response): EmitterInterface
    {
        return new Emitter($response);
    }
}
