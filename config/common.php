<?php

declare(strict_types=1);

use RazonYang\Psr7\Swoole\EmitterFactory;
use RazonYang\Psr7\Swoole\EmitterFactoryInterface;
use RazonYang\Psr7\Swoole\ServerRequestFactory;
use RazonYang\Psr7\Swoole\ServerRequestFactoryInterface;
use RazonYang\Yii\Runner\Swoole\PoolFactory;
use RazonYang\Yii\Runner\Swoole\PoolFactoryInterface;
use RazonYang\Yii\Runner\Swoole\ServerFactory;
use RazonYang\Yii\Runner\Swoole\ServerFactoryInterface;

/**
 * @var array $params
 */
return [
    PoolFactoryInterface::class => PoolFactory::class,
    PoolFactory::class => fn () => new PoolFactory($params['razonyang/yii-runner-swoole']['pool']['workerNumber']),

    ServerFactoryInterface::class => ServerFactory::class,
    ServerFactory::class => fn() => new ServerFactory(
        $params['razonyang/yii-runner-swoole']['server']['host'],
        $params['razonyang/yii-runner-swoole']['server']['port'],
    ),

    EmitterFactoryInterface::class => EmitterFactory::class,
    EmitterFactory::class => fn() => new EmitterFactory(),

    ServerRequestFactoryInterface::class => ServerRequestFactory::class,
    ServerRequestFactory::class => fn() => new ServerRequestFactory(),
];
