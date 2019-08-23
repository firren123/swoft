<?php declare(strict_types=1);


namespace App\Listener;


use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Co;
use Swoft\Consul\Agent;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;
use Swoft\Http\Server\HttpServer;
use Swoft\Log\Helper\CLog;
use Swoft\Server\SwooleEvent;
use Swoole\Coroutine;

/**
 * Class RegisterServiceListener
 *
 * @since 2.0
 * @Listener(event=SwooleEvent::START)
 */
class PayServiceListener implements EventHandlerInterface
{
    /**
     * @Inject()
     *
     * @var Agent
     */
    private $agent;

    /**
     * @param EventInterface $event
     */
    public function handle(EventInterface $event): void
    {
        /* @var HttpServer $httpServer */

//        $httpServer = $event->getTarget();
        sgo(function(){
            $config = bean('config')->get('provider.consul');
            bean('ConsulProvider')->registerServer($config);
        });


        // Register
//        $this->agent->registerService($service);
//        CLog::info('Swoft http register service success by consul!');

    }
}