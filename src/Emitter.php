<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Psr\Http\Message\ResponseInterface;
use Swoole\Http\Response;

final class Emitter implements EmitterInterface
{
    public function __construct(
        private Response $response,
    ) {
    }

    public function emit(ResponseInterface $response)
    {
        $this->response->setStatusCode($response->getStatusCode(), $response->getReasonPhrase());

        foreach ($response->getHeaders() as $key => $value) {
            $this->response->setHeader($key, $value);
        }

        $this->response->write($response->getBody()->__toString());
    }
}
