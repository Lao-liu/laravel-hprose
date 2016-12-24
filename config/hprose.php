<?php

return [

    /*
    |--------------------------------------------------------------------------
    | 客户端参数设置
    |--------------------------------------------------------------------------
    |
    | https://github.com/hprose/hprose-php/wiki/05.-Hprose-客户端
    */

    "client" => [
        "setup"      => [
            // ["hprose"=>"demo", "hprose1"=>"demo1"]
            "Header"           => [],
            "KeepAlive"        => true,
            "KeepAliveTimeout" => 300,
            "Proxy"            => '',
            "Simple"           => true,
            "Timeout"          => 30000,
            "Retry"            => 10,
            "UriList"          => [],
            "Failswitch"       => false,
            "Idempotent"       => false,
        ],
        "url"        => "",
        "async"      => false,
        // '*' 缓存全部或 'method_name1, method_name2'
        "cache"      => env("HPROSE_CACHE_METHOD", null),
        "cache_time" => env('HPROSE_CACHE_TIME', 15),
    ],

    /*
    |--------------------------------------------------------------------------
    | 客户端参数设置
    |--------------------------------------------------------------------------
    |
    | https://github.com/hprose/hprose-php/wiki/08.-HTTP-服务器特殊设置
    */

    "server" => [
        "CrossDomainEnabled" => env("HPROSE_CROSS_DOMAIN", false),
        "DebugEnabled"       => env("HPROSE_DEBUG", false),
        "P3PEnabled"         => env("HPROSE_P3P", false),
        "GetEnabled"         => env("HPROSE_GET", true),
        "Heartbeat"          => 3000,
        "Simple"             => true
    ]
];