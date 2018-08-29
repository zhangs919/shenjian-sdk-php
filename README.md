# Shenjian SDK for PHP

## 运行环境
- PHP 5.5+
- cURL extension

##安装方法

1. 在你的`composer.json`中声明对Shenjian SDK for PHP的依赖:

        "require": {
            "Shenjian/shenjian-sdk-php": "~1.3"
        }

    然后通过`composer install`安装依赖。composer安装完成后，在您的PHP代码中引入依赖即可：

        require_once __DIR__ . '/vendor/autoload.php';

2. 下载SDK源码，在您的代码中引入SDK目录下的`autoload.php`文件：

        require_once '/path/to/shenjian-sdk/autoload.php';

## 快速使用

### ShenjianClient初始化

```php
<?php
$user_key = "您的用户Key";
$user_secret = "您的用户密钥";
try{
    $shenjian_client = new ShenjianClient($user_key, $user_secret);
} catch (ShenjianException $e){
    print $e->getMessage();
}
```

### 启动爬虫

```php
<?php
$app_id = "爬虫的AppId";
$result = $shenjian_client->startCrawler($app_id);
print $result;
```

### 获取爬虫状态

```php
<?php
$app_id = "爬虫的AppId";
$result = $shenjian_client->getCrawlerStatus($app_id);
print $result;
```


### 停止爬虫

```php
<?php
$app_id = "爬虫的AppId";
$result = $shenjian_client->stopCrawler($app_id);
print $result;
```

## 代码许可

[Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0.html)


