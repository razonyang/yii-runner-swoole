<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Swoole\Process\Pool;

interface PoolFactoryInterface
{
    /**
     * Create a pool instance.
     *
     * @return Pool
     */
    public function create(): Pool;
}
