<?php
/**
 * Project ~ laravel-hprose
 * FileName: HproseServiceFacade.php
 *
 * @author  :  Liujian <laoliu@lanmv.com>
 * @package Laoliu\LaravelHprose
 *
 * Date: 2016/12/23 下午9:14
 */

namespace Laoliu\LaravelHprose;

use Illuminate\Support\Facades\Facade;

class HproseServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "HproseService";
    }
}