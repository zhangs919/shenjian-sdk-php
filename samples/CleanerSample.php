<?php

require_once __DIR__ . "/Common.php";

use Shenjian\ShenjianClient;
use Shenjian\Core\ShenjianException;
use Shenjian\Model\ProxyType;
use Shenjian\Model\HostType;
use Shenjian\Model\AppStatus;

$shenjian_client = Common::getShenjianClient();
if (is_null($shenjian_client)) exit(1);

//************************************ 简单使用 ************************************

//获取清洗应用列表
try{
    $cleaner_list = $shenjian_client->getCleanerList();
    var_dump($cleaner_list);
}catch (ShenjianException $e){
    var_dump($e->getMessage());
}

//创建API
try{
    $params['app_name'] = "清洗应用名称";
    $params['app_info'] = "清洗应用信息";
    //清洗应用代码的base64编码
    $code = @file_get_contents(__DIR__ . "/example/cleaner.js");
    $params['code'] = base64_encode($code);
    $cleaner = $shenjian_client->createCleaner($params);
}catch (ShenjianException $e){
    var_dump($e);
}

//******************************* 完整用法参考下面函数 *******************************

getCleanerList($shenjian_client);
$app_id = createCleaner($shenjian_client);
if ($app_id <= 0) exit(1);
editCleaner($shenjian_client, $app_id);
$status = startCleaner($shenjian_client, $app_id);
while($status != AppStatus::RUNNING){
    sleep(3);
    $status = getCleanerStatus($shenjian_client, $app_id);
}
sleep(3);
$status = pauseCleaner($shenjian_client, $app_id);
while($status != AppStatus::PAUSED){
    sleep(3);
    $status = getCleanerStatus($shenjian_client, $app_id);
}
$status = resumeCleaner($shenjian_client, $app_id);
while($status != AppStatus::RUNNING){
    sleep(3);
    $status = getCleanerStatus($shenjian_client, $app_id);
}
$status = stopCleaner($shenjian_client, $app_id);
while($status != AppStatus::STOPPED){
    sleep(3);
    $status = getCleanerStatus($shenjian_client, $app_id);
}
//deleteCleaner($shenjian_client, $app_id);

/**
 * 获取清洗应用列表
 *
 * @param ShenjianClient $shenjian_client
 */
function getCleanerList($shenjian_client){
    try{
        $params['page'] = 1;
        $params['page_size'] = 5;
        $cleaner_list = $shenjian_client->getCleanerList($params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");

    foreach ($cleaner_list as $cleaner){
        Common::println("Cleaner AppId: " . $cleaner->getAppId());
        Common::println("Cleaner Info: " . $cleaner->getInfo());
        Common::println("Cleaner Name: " . $cleaner->getName());
        Common::println("Cleaner Type: " . $cleaner->getType());
        Common::println("Cleaner Status: " . $cleaner->getStatus());
        Common::println("Cleaner TimeCreate: " . $cleaner->getTimeCreate());
        echo "\n";
    }
}

/**
 * 创建清洗应用
 *
 * @param ShenjianClient $shenjian_client
 */
function createCleaner($shenjian_client){
    try{
        $params['app_name'] = "清洗应用名称";
        $params['app_info'] = "清洗应用信息";
        //清洗应用代码的base64编码
        $code = @file_get_contents(__DIR__ . "/example/cleaner.js");
        $params['code'] = base64_encode($code);
        $cleaner = $shenjian_client->createCleaner($params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Cleaner AppId: " . $cleaner->getAppId());
    Common::println("Cleaner Name: " . $cleaner->getName());
    Common::println("Cleaner Status: " . $cleaner->getStatus());
    Common::println("Cleaner TimeCreate: " . $cleaner->getTimeCreate());
    return $cleaner->getAppId();
}

/**
 * 删除清洗应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function deleteCleaner($shenjian_client, $app_id){
    try{
        $shenjian_client->deleteCleaner($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 修改清洗应用信息
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function editCleaner($shenjian_client, $app_id){
    try{
        $params['app_name'] = "设置的清洗应用名称";//不设置则不修改
        $params['app_info'] = "设置的清洗应用信息";//不设置则不修改
        $shenjian_client->editCleaner($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 设置清洗应用的代理
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function configCleanerProxy($shenjian_client, $app_id){
    try{
        $params['proxy_type'] = ProxyType::BASIC;//代理IP类型
        $shenjian_client->configCleanerProxy($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 配置清洗应用的文件云托管
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function configCleanerHost($shenjian_client, $app_id){
    try{
        $params['proxy_type'] = HostType::SHENJIANSHOU;//托管类型
        $params['image'] = true;//是否托管图片类型的文件，true和非零数字都表示托管，不传表示不托管
        $params['text'] = true;//是否托管文本类型的文件，值同上
        $params['audio'] = true;//是否托管文本类型的文件，值同上
        $params['video'] = true;//是否托管文本类型的文件，值同上
        $params['application'] = true;//是否托管文本类型的文件，值同上
        $shenjian_client->configCleanerHost($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 启动清洗应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function startCleaner($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->startCleaner($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Cleaner Status : " . $status);
    return $status;
}

/**
 * 停止清洗应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function stopCleaner($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->stopCleaner($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Cleaner Status : " . $status);
    return $status;
}

/**
 * 暂停清洗应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function pauseCleaner($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->pauseCleaner($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Cleaner Status : " . $status);
    return $status;
}

/**
 * 继续清洗应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function resumeCleaner($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->resumeCleaner($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Cleaner Status : " . $status);
    return $status;
}

/**
 * 获取清洗应用状态
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function getCleanerStatus($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->getCleanerStatus($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Cleaner Status : " . $status);
    return $status;
}

/**
 * 获取清洗应用的Webhook
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function getCleanerWebhook($shenjian_client, $app_id){
    try{
        $webhook = $shenjian_client->getCleanerWebhook($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Cleaner Webhook Url: " . $webhook->getUrl());
    Common::println("Cleaner Webhook Events: " . json_encode($webhook->getEvents()));
    Common::println("Cleaner Webhook Gzip: " . $webhook->getGzip());
}

/**
 * 设置清洗应用的Webhook
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function setCleanerWebhook($shenjian_client, $app_id){
    try{
        $params['url'] = "http://www.example.com";
        $params['data_new'] = true;//新增数据是否发送webhook，true和非零数字都表示发送，不传表示不发送
        $params['data_updated'] = true;//变动数据是否发送webhook，值同上
        $params['msg_custom'] = true;//自定义消息是否发送webhook，值同上
        $params['gzip'] = true;//是否将数据压缩后发送webhook，true和非零数字都表示压缩，不传表示不压缩
        $shenjian_client->setCleanerWebhook($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 删除清洗应用的Webhook
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function deleteCleanerWebhook($shenjian_client, $app_id){
    try{
        $shenjian_client->deleteCleanerWebhook($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}