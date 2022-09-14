<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole\Test;

use PHPUnit\Framework\TestCase;
use RazonYang\Yii\Runner\Swoole\PoolFactory;

class PoolFactoryTest extends TestCase
{
    public function workerNumberProvider(): array
    {
        return [
            [1],
            [2],
            [3],
            [4],
            [5],
        ];
    }

    /**
     * @dataProvider workerNumberProvider
     */
    public function testWithWorkerNumber(int $number): void
    {
        $factory = new PoolFactory(4);

        $this->assertSame(4, $factory->getWorkerNumber());

        $new = $factory->withWorkerNumber($number);

        $this->assertSame($number, $new->getWorkerNumber());
        $this->assertNotSame($new, $factory);
    }
}
