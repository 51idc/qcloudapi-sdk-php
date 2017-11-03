## qcloudapi-sdk-php

qcloudapi-sdk-php是为了让PHP开发者能够在自己的代码里更快捷方便的使用腾讯云的API而开发的SDK工具包。

> 基于官方初级版本完全重构，不兼容原使用用法。腾讯 SDK 尿性你懂得 WTF!

### 新特性

 - 遵循 PSR-4 规范；
 - 支持 Composer 加载方式；
 - 丰富的异常捕获；
 - 支持 Proxy、Retry、Timeout；

### 资源

* [公共参数](http://wiki.qcloud.com/wiki/%E5%85%AC%E5%85%B1%E5%8F%82%E6%95%B0)
* [API列表](http://wiki.qcloud.com/wiki/API)
* [错误码](http://wiki.qcloud.com/wiki/%E9%94%99%E8%AF%AF%E7%A0%81)

### 入门

1. 申请安全凭证。
在第一次使用云API之前，用户首先需要在腾讯云网站上申请安全凭证，安全凭证包括 SecretId 和 SecretKey, SecretId 是用于标识 API 调用者的身份，SecretKey是用于加密签名字符串和服务器端验证签名字符串的密钥。SecretKey 必须严格保管，避免泄露。

### 安装

```shell
composer require anchnet/qcloudapi-sdk-php dev-master
```

### Tests

```shell
SECRET_ID=你的SecretID SECRET_KEY=你的SecretKEY php /project_path/vendor/phpunit/phpunit/phpunit --bootstrap /project_path/vendor/autoload.php --no-configuration /sdk_path/tests
```

### 使用示例

```php
    <?php
    require_once './vendor/autoload.php';

    $profile = new QcloudApi\Profile('你的secretId', '你的secretKey', '区域参数');

    $apiClient = new QcloudApi\QcloudApi(QcloudApi\QcloudApi::MODULE_CVM, $profile);
    $response = $apiClient->DescribeRegions();
    var_dump($response);
```
