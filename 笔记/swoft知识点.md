# Swoft的知识点
一键协程化

## 1.一键协程化
### 1.设置协程个数
/Users/lichenjun/www/liuxin/swoole_swoft_docker/swoft/bin/swoft
设置了协程最多多少个，这里设置了30万个
```php
Swoole\Coroutine::set([
    'max_coroutine' => 300000,
]);
```
### 2. 启动info信息
```php
root@47ba1e949b36:/var/www/swoft# php ./bin/swoft http:start
2019/08/08-13:43:14 [INFO] Swoft\SwoftApplication:setSystemAlias(485) Set alias @base=/var/www/swoft
2019/08/08-13:43:14 [INFO] Swoft\SwoftApplication:setSystemAlias(486) Set alias @app=@base/app
2019/08/08-13:43:14 [INFO] Swoft\SwoftApplication:setSystemAlias(487) Set alias @config=@base/config
2019/08/08-13:43:14 [INFO] Swoft\SwoftApplication:setSystemAlias(488) Set alias @runtime=@base/runtime
2019/08/08-13:43:14 [INFO] Project path is /var/www/swoft
2019/08/08-13:43:14 [INFO] Swoft\Processor\EnvProcessor:handle(52) Env file(/var/www/swoft/.env) is loaded
2019/08/08-13:43:14 [INFO] Swoft\Processor\AnnotationProcessor:handle(45) Annotations is scanned(autoloader 31, annotation 435, parser 90)
2019/08/08-13:43:14 [INFO] Swoft\Processor\BeanProcessor:handle(55) config path=/var/www/swoft/config
2019/08/08-13:43:14 [INFO] Swoft\Processor\BeanProcessor:handle(56) config env=
2019/08/08-13:43:14 [INFO] Swoft\Processor\BeanProcessor:handle(60) Bean is initialized(singleton 296, prototype 75, definition 41)
2019/08/08-13:43:14 [INFO] Swoft\Processor\EventProcessor:handle(33) Event manager initialized(61 listener, 4 subscriber)
2019/08/08-13:43:14 [INFO] Swoft\WebSocket\Server\Listener\AppInitCompleteListener:handle(35) WebSocket server route registered(module 2, message command 3)
2019/08/08-13:43:14 [INFO] Swoft\Tcp\Server\Listener\AppInitCompleteListener:handle(41) Tcp server route registered(routes 4)
2019/08/08-13:43:14 [INFO] Swoft\Error\Listener\AppInitCompleteListener:handle(37) Error manager init completed(4 type, 5 handler, 5 exception)
2019/08/08-13:43:14 [INFO] Swoft\Processor\ConsoleProcessor:handle(39) Console command route registered (group 14, command 42)
                            Information Panel
  **********************************************************************
  * HTTP     | Listen: 0.0.0.0:9500, type: TCP, mode: Process, worker: 1
  * RPC      | Listen: 0.0.0.0:18307, type: TCP
  **********************************************************************

HTTP server start success !
2019/08/08-13:43:14 [INFO] Swoft\Server\Server:startSwoole(492) Swoole\Runtime::enableCoroutine
2019/08/08-13:43:14 [INFO] Swoft\Listener\BeforeStartListener:handle(27) Server extra info: pidFile @runtime/swoft.pid
2019/08/08-13:43:14 [INFO] Swoft\Listener\BeforeStartListener:handle(28) Registered swoole events:
 start, shutdown, managerStart, managerStop, workerStart, workerStop, workerError, request, task, finish
2019/08/08-13:43:14 [INFO] App\Listener\Test\StartListener:handle(29) Start context=Swoft\Server\Context\StartContext
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
Server start success (Master PID: 440, Manager PID: 443)
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\TaskProcessListener:handle(27) Task worker start
2019/08/08-13:43:14 [INFO] App\Listener\Test\WorkerStartListener:handle(28) Worker Start context=Swoft\Server\Context\WorkerStartContext
```
## 2 注解类
```php
/**
 * Class HomeController
 * @Controller("/home")     #注解路由
 */
class HomeController
{
    /**
     * @RequestMapping("/")    #注解路由
     * @throws Throwable
     */
    public function index(): Response
    {
        /** @var Renderer $renderer */
        $renderer = Swoft::getBean('view');
        $content  = $renderer->render('home/index');

        return Context::mustGet()->getResponse()->withContentType(ContentType::HTML)->withContent($content);
    }
    /**
     * @RequestMapping("test[/{name}]")     #注解路由
     * @throws Throwable
     */
    public function good(string $name):Response
    {
        return Context::mustGet()->getResponse()->withContent('Test Hello' . ($name === '' ? '' : ", {$name}"));

    }
    /**
     * @RequestMapping("/hello[/{name}]")      #注解路由
     * @param string $name
     *
     * @return Response
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function hello(string $name): Response
    {
        return Context::mustGet()->getResponse()->withContent('Hello' . ($name === '' ? '' : ", {$name}"));
    }
}

```
## 3.别名类注释
```php
@Bean("aaa")
 class b{
 }
 #可以直接使用aaa就是使用b类
```