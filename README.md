# Hprose for laravel and lumen 5.x

Hprose [https://github.com/hprose](https://github.com/hprose)

`HPROSE` is a High Performance Remote Object Service Engine.

It is a modern, lightweight, cross-language, cross-platform, object-oriented, high performance, remote dynamic communication middleware. 
It is not only easy to use, but powerful. 

## Installation

```
# composer
composer require lao-liu/laravel-hprose
```

## For Laravel 5.x

### Configuration

```php
# edit app/config/app.php
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
config file

```
# config/hprose.php
```

### Usage for laravel

#### Hprose client

```php
use RpcClient as Rpc;
$result = Rpc::someServerMethod($params);
```

#### Hprose server

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
Done.

## For Lumen 5.x

### Configuration

```php
# edit bootstrap/app.php
$app->register(Laoliu\LaravelHprose\HproseServiceProvider::class);

[...]

class_alias('Laoliu\LaravelHprose\HproseClientFacade', 'RpcClient');
class_alias('Laoliu\LaravelHprose\HproseServerFacade', 'RpcServer');
class_alias('Laoliu\LaravelHprose\HproseServiceFacade', 'RpcService');

return $app;
```
### Usage for lumen

#### Hprose client

```php
$rpc = app('RpcClient')->use('http://hproseServiceUrl/', $async);
$result = $rpc->remoteMethods($params);
```

#### Hprose server

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

### API Reference

Please refer to [https://github.com/hprose/hprose-php](https://github.com/hprose/hprose-php)