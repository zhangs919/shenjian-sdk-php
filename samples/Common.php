<?php

if (is_file(__DIR__ . '/../autoload.php')) {
    require_once __DIR__ . '/../autoload.php';
}
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}
require_once __DIR__ . '/Config.php';

use Shenjian\ShenjianClient;
use Shenjian\Core\ShenjianException;

/**
 * Class Common
 *
 * 示例程序【Samples/*.php】 的Common类，用于获取ShenjianClient实例
 */
class Common
{
    const user_key = Config::USER_KEY;
    const user_secret = Config::USER_SECRET;

    /**
     * 根据Config配置，得到一个ShenjianClient实例
     *
     * @return ShenjianClient 一个ShenjianClient实例
     */
    public static function getShenjianClient()
    {
        try {
            $shenjian_client = new ShenjianClient(self::user_key, self::user_secret);
        } catch (ShenjianException $e) {
            printf(__FUNCTION__ . "creating ShenjianClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        return $shenjian_client;
    }

    public static function println($message)
    {
        if (!empty($message)) {
            echo strval($message) . "\n";
        }
    }
}