<?php

declare(strict_types=1);

return [
    'razonyang/yii-runner-swoole' => [
        'pool' => [
            'workerNumber' => 4,
        ],
        'server' => [
            'host' => '0.0.0.0',
            'port' => 9501,
        ],
        'coroutine' => [
            'options' => [
                // See https://wiki.swoole.com/#/coroutine/coroutine?id=set.
                // 'log_level' => SWOOLE_LOG_TRACE,
                // 'trace_flags' => SWOOLE_TRACE_ALL,
            ],
        ],
    ],
];
