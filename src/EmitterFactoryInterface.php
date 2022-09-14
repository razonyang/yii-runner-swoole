<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Swoole\Http\Response;

interface EmitterFactoryInterface
{
    /**
     * Create emitter instance with the given Swoole response.
     *
     * @param Response $response
     *
     * @return EmitterInterface
     */
    public function create(Response $response): EmitterInterface;
}
