<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Swoole\Process\Pool;

final class PoolFactory implements PoolFactoryInterface
{
    public function __construct(
        private int $workerNumber,
    ) {
    }

    public function withWorkerNumber(int $number): static
    {
        $new = clone $this;
        $new->workerNumber = $number;

        return $new;
    }

    public function getWorkerNumber(): int
    {
        return $this->workerNumber;
    }

    public function create(): Pool
    {
        $pool = new Pool($this->workerNumber, 0, 0, true);

        return $pool;
    }
}
