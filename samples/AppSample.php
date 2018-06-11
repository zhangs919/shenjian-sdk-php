<?php

require_once __DIR__ ."/Common.php";

use Shenjian\ShenjianClient;
use Shenjian\Core\ShenjianException;

$shenjian_client = Common::getShenjianClient();
if (is_null($shenjian_client)) exit(1);

//************************************ 简单使用 ************************************

//获取App列表
try{
    $app_list = $shenjian_client->getAppList();
    var_dump($app_list);
}catch (ShenjianException $e){
    var_dump($e->getMessage());
}

//******************************* 完整用法参考下面函数 *******************************

getAppList($shenjian_client);

/**
 * 获取App列表
 *
 * @param ShenjianClient $shenjian_client
 */
function getAppList($shenjian_client){
    try{
        $params['page'] = 1;
        $params['page_size'] = 5;
        $app_list = $shenjian_client->getAppList($params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    foreach ($app_list as $app){
        Common::println("AppId: " . $app->getAppId());
        Common::println("Info: " . $app->getInfo());
        Common::println("Name: " . $app->getName());
        Common::println("Type: " . $app->getType());
        Common::println("Status: " . $app->getStatus());
        Common::println("TimeCreate: " . $app->getTimeCreate());
        echo("\n");
    }
}