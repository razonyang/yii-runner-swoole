# Yii Swoole Application Runner

[![Latest Stable Version](https://poser.pugx.org/razonyang/yii-runner-swoole/v/stable.png)](https://packagist.org/packages/razonyang/yii-runner-swoole)
[![Total Downloads](https://poser.pugx.org/razonyang/yii-runner-swoole/downloads.png)](https://packagist.org/packages/razonyang/yii-runner-swoole)
[![Build Status](https://github.com/razonyang/yii-runner-swoole/workflows/build/badge.svg)](https://github.com/razonyang/yii-runner-swoole/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/razonyang/yii-runner-swoole/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/razonyang/yii-runner-swoole/?branch=main)
[![Code Coverage](https://scrutinizer-ci.com/g/razonyang/yii-runner-swoole/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/razonyang/yii-runner-swoole/?branch=main)

The Swoole adapter for [Yii Runner](https://github.com/yiisoft/yii-runner), built on top of Swoole coroutine.

## Installation

```bash
composer require razonyang/yii-runner-swoole --prefer-dist
```

## Entrypoint

```php
<?php
// server.php
declare(strict_types=1);

use RazonYang\Yii\Runner\Swoole\SwooleApplicationRunner;

ini_set('display_errors', 'stderr');

require_once __DIR__ . '/autoload.php';

(new SwooleApplicationRunner(__DIR__, $_ENV['YII_DEBUG'], $_ENV['YII_ENV']))->run();
```

Start the server.

```bash
php server.php
```

## Configuration

```php
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
```
