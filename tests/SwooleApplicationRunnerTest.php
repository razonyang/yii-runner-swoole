<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole\Tests;

use RazonYang\Psr7\Swoole\ServerRequestFactory;
use RazonYang\Yii\Runner\Swoole\SwooleApplicationRunner;
use ReflectionClass;

class SwooleApplicationRunnerTest extends TestCase
{
    // TODO
    public function testHandle(): void
    {
        $runner = $this->createRunner();
        $this->assertNotEmpty($runner);
    }

    private function createRunner(): SwooleApplicationRunner
    {
        $runner = new SwooleApplicationRunner(__DIR__, false, 'dev');

        $class = new ReflectionClass($runner);

        $serverRequestFactory = $class->getProperty('serverRequestFactory');
        $serverRequestFactory->setAccessible(true);
        $serverRequestFactory->setValue($runner, new ServerRequestFactory());

        return $runner;
    }
}
