<?php

declare(strict_types=1);

use Swoole\Coroutine;

/**
 * @var array $params
 */
return [
    function() use($params) {
        if (!empty($params['razonyang/yii-runner-swoole']['coroutine']['options'])) {
            Coroutine::set($params['razonyang/yii-runner-swoole']['coroutine']['options']);
        }
    },
];
