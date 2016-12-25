# Hprose for laravel 5.x

Hprose [https://github.com/hprose](https://github.com/hprose)

`HPROSE` is a High Performance Remote Object Service Engine.

It is a modern, lightweight, cross-language, cross-platform, object-oriented, high performance, remote dynamic communication middleware. 
It is not only easy to use, but powerful. 

## Installation

```
# composer
composer require lao-liu/laravel-hprose
```

## Configuration

```
# config/hprose.php
```

```php
# app/config/app.php
# include the provider
'providers' => [
    [...]
    Laoliu\LaravelHprose\HproseServiceProvider::class,
];

# include the alias
'aliases' => [
    [...]
    'RpcClient'    => Laoliu\LaravelHprose\HproseClientFacade::class,
    'RpcServer'    => Laoliu\LaravelHprose\HproseServerFacade::class,
    'RpcService'   => Laoliu\LaravelHprose\HproseServiceFacade::class,
];

# Laravel config
php artisan vendor:publish --provider="Laoliu\LaravelHprose\HproseServiceProvider"
```

## Usage

### Hprose client

```php
use RpcClient as Rpc;
$result = Rpc::someServerMethod($params);
```

### Hprose server

```php
Route::any('/api', function() {
    $server = app('RpcServer');
    
    // Hprose support XmlRPC and JsonRPC
    // if want support XmlRpc
    $server->addFilter(new Hprose\Filter\XMLRPC\ServiceFilter());
    // if want support JsonRpc
    $server->addFilter(new Hprose\Filter\JSONRPC\ServiceFilter());
    
    $server->addInstanceMethods(new \App\Services\SomeHprosePublishServices());
    $server->start();
});
```

### Middleware setting

```php
# app/Http/Middleware/VerifyCsrfToken.php
[...]
protected $except = [
    'api' // OR 'api*'
];
```

### API Reference

Please refer to [https://github.com/hprose/hprose-php](https://github.com/hprose/hprose-php)