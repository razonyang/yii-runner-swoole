<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use ReflectionClass;

class TestCase extends BaseTestCase
{
    public function callMethod($obj, $name, array $args)
    {
        $class = new ReflectionClass($obj);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method->invokeArgs($obj, $args);
    }
}
