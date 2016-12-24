<?php
/**
 * Project ~ laravel-hprose
 * FileName: HproseClientFacade.php
 *
 * @author  :  Liujian <laoliu@lanmv.com>
 * @package Laoliu\LaravelHprose
 *
 * Date: 2016/12/23 上午7:50
 */

namespace Laoliu\LaravelHprose;

use Illuminate\Support\Facades\Facade;

class HproseClientFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "RpcClient";
    }
}