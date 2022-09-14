<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Psr\Http\Message\ResponseInterface;

interface EmitterInterface
{
    /**
     * Emits a PSR-7 response.
     *
     * @param ResponseInterface $response
     */
    public function emit(ResponseInterface $response);
}
