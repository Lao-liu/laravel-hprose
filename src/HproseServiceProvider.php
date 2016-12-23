<?php
/**
 * Project ~ laravel-hprose
 * FileName: HproseServiceProvider.php
 *
 * @author  :  Liujian <laoliu@lanmv.com>
 * @package Laoliu\LaravelHprose
 *
 * Date: 2016/12/22 下午9:43
 */

namespace Laoliu\LaravelHprose;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Hprose;

class HproseServiceProvider extends ServiceProvider
{
    protected $defer = false;

    public function boot()
    {
        // vendor:publish 生成配置文件
        $configPath = __DIR__ . '/../config/hprose.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('hprose.php');
        } else {
            $publishPath = base_path('config/hprose.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');

        // 设置别名
        $loader = AliasLoader::getInstance();
        $loader->alias('HproseClient', 'Lao-liu\LaravelHprose\HproseClientFacade');
        $loader->alias('HproseServer', 'Lao-liu\LaravelHprose\HproseServerFacade');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/hprose.php', 'hprose');
        $this->app->singleton('HproseClient', function(){
            $options = $this->app["config"]->get("hprose.client");
            $client = new HproseClientWrapper($options);
            return $client;
        });

        $this->app->bind('HproseServer', function($app, $params=[]){
            $options = $this->app["config"]->get("hprose.server");
            $class = \ReflectionClass(Hprose\Http\Server::class);
            $server = $class->newInstanceArgs($params);
            return $server;
        });
    }

    protected function mergeConfigFrom($path, $key='hprose')
    {
        $config_usr = $this->app["config"]->get($key, []);
        $config_pkg = require $path;

        $config = [];
        $config["client"] = array_merge($config_pkg["client"], @$config_usr["client"] ?: []);
        $config["server"] = array_merge($config_pkg["server"], @$config_usr["server"] ?: []);

        $this->app["config"]->set($key, $config);
    }

    public function provides()
    {
        return ["HproseClient", "HproseServer"];
    }
}