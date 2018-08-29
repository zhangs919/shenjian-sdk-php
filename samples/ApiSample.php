<?php

require_once __DIR__ . "/Common.php";

use Shenjian\ShenjianClient;
use Shenjian\Core\ShenjianException;
use Shenjian\Model\ProxyType;
use Shenjian\Model\HostType;

$shenjian_client = Common::getShenjianClient();
if (is_null($shenjian_client)) exit(1);

//************************************ 简单使用 ************************************

//获取API列表
try{
    $api_list = $shenjian_client->getApiList();
    var_dump($api_list);
}catch (ShenjianException $e){
    var_dump($e->getMessage());
}

//创建API
try{
    $params['app_name'] = "API名称";
    $params['app_info'] = "API信息";
    //API应用代码的base64编码
    $code = @file_get_contents(__DIR__ . "/example/api.js");
    $params['code'] = base64_encode($code);
    $api = $shenjian_client->createApi($params);
    var_dump($api);
}catch (ShenjianException $e){
    var_dump($e->getMessage());
}

//******************************* 完整用法参考下面函数 *******************************

getApiList($shenjian_client);
$app_id = createApi($shenjian_client);
if($app_id <= 0) exit(1);
editApi($shenjian_client, $app_id);
getApiKey($shenjian_client, $app_id);
//deleteApi($shenjian_client, $app_id);

/**
 * 获取API列表
 *
 * @param ShenjianClient $shenjian_client
 */
function getApiList($shenjian_client){
    try{
        $params['page'] = 1;
        $params['page_size'] = 5;
        $api_list = $shenjian_client->getApiList($params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");

    foreach ($api_list as $api){
        Common::println("Api AppId: " . $api->getAppId());
        Common::println("Api Info: " . $api->getInfo());
        Common::println("Api Name: " . $api->getName());
        Common::println("Api Type: " . $api->getType());
        Common::println("Api Status: " . $api->getStatus());
        Common::println("Api TimeCreate: " . $api->getTimeCreate());
        echo "\n";
    }
}

/**
 * 创建API
 *
 * @param ShenjianClient $shenjian_client
 */
function createApi($shenjian_client){
    try{
        $params['app_name'] = "API名称";
        $params['app_info'] = "API信息";
        //API应用代码的base64编码
        $code = @file_get_contents(__DIR__ . "/example/api.js");
        $params['code'] = base64_encode($code);
        $api = $shenjian_client->createApi($params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("API AppId: " . $api->getAppId());
    Common::println("API Name: " . $api->getName());
    Common::println("API Status: " . $api->getStatus());
    Common::println("API TimeCreate: " . $api->getTimeCreate());
    return $api->getAppId();
}

/**
 * 删除API
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function deleteApi($shenjian_client, $app_id){
    try{
        $shenjian_client->deleteApi($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 修改API信息
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function editApi($shenjian_client, $app_id){
    try{
        $params['app_name'] = "设置的API名称";//不设置则不修改
        $params['app_info'] = "设置的API信息";//不设置则不修改
        $shenjian_client->editApi($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 配置代理
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function configApiProxy($shenjian_client, $app_id){
    try{
        $params['proxy_type'] = ProxyType::BASIC;//代理IP类型
        $shenjian_client->configApiProxy($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 配置文件云托管
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function configApiHost($shenjian_client, $app_id){
    try{
        $params['proxy_type'] = HostType::SHENJIANSHOU;//托管类型
        $params['image'] = true;//是否托管图片类型的文件，true和非零数字都表示托管，不传表示不托管
        $params['text'] = true;//是否托管文本类型的文件，值同上
        $params['audio'] = true;//是否托管文本类型的文件，值同上
        $params['video'] = true;//是否托管文本类型的文件，值同上
        $params['application'] = true;//是否托管文本类型的文件，值同上
        $shenjian_client->configApiHost($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 获取API的调用key
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function getApiKey($shenjian_client, $app_id){
    try{
        $api_key = $shenjian_client->getApiKey($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("API Key: {$api_key}");
}