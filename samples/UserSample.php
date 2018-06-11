<?php

require_once __DIR__ . "/Common.php";

use Shenjian\ShenjianClient;
use Shenjian\Core\ShenjianException;

$shenjian_client = Common::getShenjianClient();
if (is_null($shenjian_client)) exit(1);

//************************************ 简单使用 ************************************

//获取账号余额
try{
    $money = $shenjian_client->getMoney();
    var_dump($money);
}catch (ShenjianException $e){
    var_dump($e->getMessage());
}

//获取节点信息
try{
    $node = $shenjian_client->getNode();
    var_dump($node);
}catch (ShenjianException $e){
    var_dump($e->getMessage());
}

//******************************* 完整用法参考下面函数 *******************************

getMoney($shenjian_client);
getNode($shenjian_client);

/**
 * 获取账号余额
 *
 * @param ShenjianClient $shenjian_client
 */
function getMoney($shenjian_client){
    try{
        $money = $shenjian_client->getMoney();
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Money: ". $money);
}

/**
 * 获取节点信息
 *
 * @param ShenjianClient $shenjian_client
 */
function getNode($shenjian_client){
    try{
        $node = $shenjian_client->getNode();
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Node All: " . $node->getNodeAll());
    Common::println("Node Running: " . $node->getNodeRunning());
    Common::println("Node Gpu All: " . $node->getNodeGpuAll());
    Common::println("Node Gpu Running: " . $node->getNodeGpuRunning());
}