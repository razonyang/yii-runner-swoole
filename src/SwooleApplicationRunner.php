<?php

declare(strict_types=1);

namespace RazonYang\Yii\Runner\Swoole;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Swoole\Coroutine\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Process;
use Swoole\Process\Pool;
use Throwable;
use Yiisoft\Di\StateResetter;
use Yiisoft\Http\Status;
use Yiisoft\Yii\Http\Application;
use Yiisoft\Yii\Runner\ApplicationRunner;
use Yiisoft\Yii\Runner\Http\ServerRequestFactory;
use Yiisoft\Yii\Runner\RunnerInterface;

final class SwooleApplicationRunner extends ApplicationRunner implements RunnerInterface
{
    private ?Application $application;

    private ?LoggerInterface $logger;

    private ?EmitterFactoryInterface $emitterFactory;

    private ?ServerRequestFactory $serverRequestFactory;

    private ?ResponseFactoryInterface $responseFactory;

    /**
     * @param string $rootPath The absolute path to the project root.
     * @param bool $debug Whether the debug mode is enabled.
     * @param string|null $environment The environment name.
     */
    public function __construct(
        string $rootPath,
        bool $debug,
        ?string $environment,
    ) {
        parent::__construct($rootPath, $debug, $environment);
        $this->bootstrapGroup = 'bootstrap-web';
        $this->eventsGroup = 'events-web';
    }

    public function run(): void
    {
        $this->init();

        $pool = $this->createPool();
        $pool->start();
    }

    private function init()
    {
        $config = $this->getConfig();
        $container = $this->getContainer($config, 'web');

        $this->runBootstrap($config, $container);
        $this->checkEvents($config, $container);

        $this->logger = $container->get(LoggerInterface::class);

        $this->application = $container->get(Application::class);

        $this->emitterFactory = $container->get(EmitterFactoryInterface::class);

        $this->serverRequestFactory = $container->get(ServerRequestFactory::class);

        $this->responseFactory = $container->get(ResponseFactoryInterface::class);
    }

    private function createPool(): Pool
    {
        $factory = $this->container->get(PoolFactoryInterface::class);
        $pool = $factory->create();

        $pool->on('workerStart', [$this, 'onWorkerStart']);

        return $pool;
    }

    private function onWorkerStart(Pool $pool, int $id): void
    {
        $server = $this->createServer();

        Process::signal(SIGTERM, function () use ($server) {
            $this->application->shutdown();
            $server->shutdown();
        });

        $this->application->start();
        $server->start();
    }

    private function createServer(): Server
    {
        $factory = $this->container->get(ServerFactoryInterface::class);
        $srv = $factory->create();

        $srv->handle('/', [$this, 'handle']);

        return $srv;
    }

    private function handle(Request $request, Response $response): void
    {
        $psrResponse = null;
        $emitter = $this->emitterFactory->create($response);
        try {
            $psrRequest = $this->createServerRequest($request);
            $psrResponse = $this->application->handle($psrRequest);
            $emitter->emit($psrResponse);
        } catch (Throwable $t) {
            $this->logger->error($t->getMessage());
            $psrResponse = $this->responseFactory->createResponse(Status::INTERNAL_SERVER_ERROR, Status::TEXTS[Status::INTERNAL_SERVER_ERROR]);
            $emitter->emit($psrResponse);
        } finally {
            $this->afterRespond($psrResponse);
        }
    }

    private function createServerRequest(Request $request): ServerRequestInterface
    {
        $server = array_change_key_case($request->server ?: [], CASE_UPPER);
        $server['SCRIPT_NAME'] = $this->getScriptName();

        return $this->serverRequestFactory->createFromParameters(
            $server,
            $request->header ?: [],
            $request->cookie ?: [],
            $request->get ?: [],
            $request->post ?: [],
            $request->files ?: [],
            $request->getContent(),
        );
    }

    private function getScriptName(): string
    {
        global $argv;

        return $argv[0]??'';
    }

    private function afterRespond(
        ?ResponseInterface $response,
    ): void {
        $this->application->afterEmit($response);
        /** @psalm-suppress MixedMethodCall */
        $this->container
            ->get(StateResetter::class)
            ->reset(); // We should reset the state of such services every request.
        gc_collect_cycles();
    }
}
