<?php
/**
 * Project ~ laravel-hprose
 * FileName: HproseClientWrapper.php
 *
 * @author  :  Liujian <laoliu@lanmv.com>
 * @package Laoliu\LaravelHprose
 *
 * Date: 2016/12/22 下午9:59
 */

namespace Laoliu\LaravelHprose;

use Log;
use Cache;
use Hprose;

class HproseClientWrapper
{
    private $connection = null;
    protected $config = [];

    /**
     * HproseClientWrapper constructor.
     *
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->configure($options);
    }

    public function configure($options) {
        $this->config = array_merge($this->config, $options);
    }

    public function connection() {
        if (!$this->connection)
            $this->connection = $this->connection_init();

        return $this->connection;
    }

    private function connection_init()
    {
        $opts = $this->config;
        if(!count($opts["setup"]["UriList"])){
            if(filter_var($opts['url'], FILTER_VALIDATE_URL)){
                if(!isset($opts['async'])) $opts['async'] = false;
                $client = new Hprose\Http\Client($opts['url'], $opts['async']);
            } else {
                trigger_error("Hprose 接口地址必须设置");
            }
        } else {
            $UriList = $opts["setup"]["UriList"];
            $client = new Hprose\Http\Client(key($UriList), $UriList[key($UriList)]);
        }

        foreach ($opts['setup']['Header'] as $key => $value)
            $client->setHeader($key, $value);

        if(isset($opts['setup']['Proxy']) && $opts['setup']['Proxy']){
            $client->proxy = $opts['setup']['Proxy'];
        }

        return $client;
    }

    protected function request($method, $params)
    {
        Log::debug('HproseClient call', ['method'=>$method, 'params'=>$params, 'config'=>$this->config]);

        return call_user_func_array(
            [$this->connection(), $method],
            [$method,$params]
        );
    }

    public function __call($method_name, $arguments) {
        if ($this->cache_allowed($method_name))
        {
            $key = "hprose-$method_name-". md5(json_encode($arguments));
            $time = $this->config['cache_time'];

            $request = [$this, 'request'];

            return Cache::remember($key, $time, function() use ($method_name, $arguments, $request) {
                return call_user_func_array(
                    $request,
                    [$method_name, $arguments]
                );
            });
        }

        return $this->request($method_name, $arguments);
    }

    protected function cache_allowed($method_name) {
        $allow = $this->config['cache'];
        if (!is_array($allow))
            $allow = [$allow];

        if(is_string($allow) && strstr(',', $allow)){
            $allow = explode(',', $allow);
        }

        if (in_array('*', $allow))
            return true;
        if (in_array($method_name, $allow))
            return true;

        return false;
    }
}