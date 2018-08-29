<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/2/2
 * Time: 15:02
 */
require_once __DIR__ . "/Common.php";

use Shenjian\ShenjianClient;
use Shenjian\Core\ShenjianException;
use Shenjian\Model\ProxyType;
use Shenjian\Model\HostType;
use Shenjian\Model\AppStatus;


$shenjian_client = Common::getShenjianClient();
if (is_null($shenjian_client)) exit(1);

//************************************ 简单使用 ************************************

//获取爬虫应用列表
try{
    $crawler_list = $shenjian_client->getCrawlerList();
    var_dump($crawler_list);
}catch (ShenjianException $e){
    var_dump($e->getMessage());
}

//创建爬虫应用
try{
    $params['app_name'] = "爬虫应用名称";
    $params['app_info'] = "爬虫应用信息";
    //爬虫应用代码的base64编码
    $code = @file_get_contents(__DIR__ . "/example/crawler.js");
    $params['code'] = base64_encode($code);
    $crawler = $shenjian_client->createCrawler($params);
    var_dump($crawler);
}catch (ShenjianException $e){
    var_dump($e->getMessage());
}

//******************************* 完整用法参考下面函数 *******************************

getCrawlerList($shenjian_client);
$app_id = createCrawler($shenjian_client);
if ($app_id <= 0) exit(1);
editCrawler($shenjian_client, $app_id);
configCrawlerCustomGet($shenjian_client, $app_id);
$status = startCrawler($shenjian_client, $app_id);
while($status != AppStatus::RUNNING){
    sleep(3);
    $status = getCrawlerStatus($shenjian_client, $app_id);
}
getCrawlerSpeed($shenjian_client, $app_id);
$source_count = 0;
while($source_count <= 0){
    sleep(3);
    $source_count = getCrawlerSource($shenjian_client, $app_id);
}
$status = pauseCrawler($shenjian_client,$app_id);
while($status != AppStatus::PAUSED){
    sleep(3);
    $status = getCrawlerStatus($shenjian_client, $app_id);
}
$status = resumeCrawler($shenjian_client,$app_id);
while($status != AppStatus::RUNNING){
    sleep(3);
    $status = getCrawlerStatus($shenjian_client, $app_id);
}
$status = stopCrawler($shenjian_client, $app_id);
while($status != AppStatus::STOPPED){
    sleep(3);
    $status = getCrawlerStatus($shenjian_client, $app_id);
}
//deleteCrawler($shenjian_client, $app_id);

/**
 * 获取爬虫应用列表
 *
 * @param ShenjianClient $shenjian_client
 */
function getCrawlerList($shenjian_client){
    try{
        $params['page'] = 1;
        $params['page_size'] = 5;
        $crawler_list = $shenjian_client->getCrawlerList($params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");

    foreach ($crawler_list as $crawler){
        Common::println("Crawler AppId: " . $crawler->getAppId());
        Common::println("Crawler Info: " . $crawler->getInfo());
        Common::println("Crawler Name: " . $crawler->getName());
        Common::println("Crawler Type: " . $crawler->getType());
        Common::println("Crawler Status: " . $crawler->getStatus());
        Common::println("Crawler TimeCreate: " . $crawler->getTimeCreate());
        echo "\n";
    }
}

/**
 * 创建爬虫应用
 *
 * @param ShenjianClient $shenjian_client
 */
function createCrawler($shenjian_client){
    try{
        $params['app_name'] = "爬虫应用名称";
        $params['app_info'] = "爬虫应用信息";
        //爬虫应用代码的base64编码
        $code = @file_get_contents(__DIR__ . "/example/crawler.js");
        $params['code'] = base64_encode($code);
        $crawler = $shenjian_client->createCrawler($params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Crawler AppId: " . $crawler->getAppId());
    Common::println("Crawler Name: " . $crawler->getName());
    Common::println("Crawler Status: " . $crawler->getStatus());
    Common::println("Crawler TimeCreate: " . $crawler->getTimeCreate());
    return $crawler->getAppId();
}

/**
 * 删除爬虫应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function deleteCrawler($shenjian_client, $app_id){
    try{
        $shenjian_client->deleteCrawler($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 修改爬虫应用信息
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function editCrawler($shenjian_client, $app_id){
    try{
        $params['app_name'] = "设置的爬虫应用名称";//不设置则不修改
        $params['app_info'] = "设置的爬虫应用信息";//不设置则不修改
        $shenjian_client->editCrawler($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 获取爬虫应用的自定义项
 * 
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function configCrawlerCustomGet($shenjian_client, $app_id){
    try{
        $custom_list = $shenjian_client->configCrawlerCustomGet($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    if(is_array($custom_list)){
        foreach ($custom_list as $custom){
            Common::println("Custom Key: " . $custom->getKey());
            Common::println("Custom Name: " . $custom->getName());
            Common::println("Custom Type: " . $custom->getType());
            Common::println("Custom Cvalue:" . $custom->getCvalue());
            echo "\n";
        }
    }else{
        Common::println("Reason: " . $custom_list);
    }
}

/**
 * 启动爬虫应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function startCrawler($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->startCrawler($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Crawler Status : " . $status);
    return $status;
}

/**
 * 停止爬虫应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function stopCrawler($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->stopCrawler($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Crawler Status : " . $status);
    return $status;
}

/**
 * 暂停爬虫应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function pauseCrawler($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->pauseCrawler($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Crawler Status : " . $status);
    return $status;
}

/**
 * 继续爬虫应用
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function resumeCrawler($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->resumeCrawler($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Crawler Status : " . $status);
    return $status;
}

/**
 * 获取爬虫应用状态
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function getCrawlerStatus($shenjian_client, $app_id){
    try{
        $status = $shenjian_client->getCrawlerStatus($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Crawler Status : " . $status);
    return $status;
}

/**
 * 获取爬虫应用速率
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function getCrawlerSpeed($shenjian_client, $app_id){
    try{
        $speed = $shenjian_client->getCrawlerSpeed($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Crawler Speed : " . $speed);
}

/**
 * 修改爬虫应用的运行节点
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function changeCrawlerNode($shenjian_client, $app_id){
    try{
        $params['node_delta'] = 1;
        $node = $shenjian_client->changeCrawlerNode($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Node Running : " . $node->getNodeRunning());
    Common::println("Node Left : " . $node->getNodeLeft());
}

/**
 * 获取爬虫应用的数据信息
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function getCrawlerSource($shenjian_client, $app_id){
    try{
        $source = $shenjian_client->getCrawlerSource($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Source AppId: " . $source->getAppId());
    Common::println("Source Type: " . $source->getType());
    Common::println("Source Count: " . $source->getCount());
    return $source->getCount();
}

/**
 * 清空爬虫应用数据
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function clearCrawlerSource($shenjian_client, $app_id){
    try{
        $shenjian_client->clearCrawlerSource($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 删除爬虫应用数据
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function deleteCrawlerSource($shenjian_client, $app_id){
    try{
        $params['days'] = 1;//删除多少天前的数据，无默认值，最小为1
        $shenjian_client->deleteCrawlerSource($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 设置爬虫应用的代理
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function configCrawlerProxy($shenjian_client, $app_id){
    try{
        $params['proxy_type'] = ProxyType::BASIC;//代理IP类型
        $shenjian_client->configCrawlerProxy($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 设置爬虫应用的托管
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function configCrawlerHost($shenjian_client, $app_id){
    try{
        $params['proxy_type'] = HostType::SHENJIANSHOU;//托管类型
        $params['image'] = true;//是否托管图片类型的文件，true和非零数字都表示托管，不传表示不托管
        $params['text'] = true;//是否托管文本类型的文件，值同上
        $params['audio'] = true;//是否托管文本类型的文件，值同上
        $params['video'] = true;//是否托管文本类型的文件，值同上
        $params['application'] = true;//是否托管文本类型的文件，值同上
        $shenjian_client->configCrawlerHost($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}


/**
 * 获取爬虫应用的Webhook设置
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function getCrawlerWebhook($shenjian_client, $app_id){
    try{
        $webhook = $shenjian_client->getCrawlerWebhook($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Crawler Webhook Url: " . $webhook->getUrl());
    Common::println("Crawler Webhook Events: " . json_encode($webhook->getEvents()));
    Common::println("Crawler Webhook Gzip: " . $webhook->getGzip());
}


/**
 * 删除爬虫应用的Webhook
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function deleteCrawleWebhook($shenjian_client, $app_id){
    try{
        $shenjian_client->deleteCrawleWebhook($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 修改爬虫应用的Webhook
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function setCrawlerWebhook($shenjian_client, $app_id){
    try{
        $params['url'] = "http://www.example.com";//webhook的通知地址，需要是能外网访问的地址
        $params['data_new'] = true;//新增数据是否发送webhook，true和非零数字都表示发送，不传表示不发送
        $params['data_updated'] = true;//变动数据是否发送webhook，值同上
        $params['msg_custom'] = true;//自定义消息是否发送webhook，值同上
        $params['gzip'] = true;//是否将数据压缩后发送webhook，true和非零数字都表示压缩，不传表示不压缩
        $shenjian_client->setCrawlerWebhook($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 获取爬虫应用的自动发布状态
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function getCrawlerPublishStatus($shenjian_client, $app_id){
    try{
        $publish_status = $shenjian_client->getCrawlerPublishStatus($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
    Common::println("Publish Status: " . $publish_status);
}

/**
 * 开启爬虫应用的自动发布
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function startCrawlerPublish($shenjian_client, $app_id){
    try{
        $params['publish_id'] = ["发布项目的Id", "发布项目的Id"];//发布项ID（发布项目前只能通过网页创建，暂时不开放通过接口创建）
        $shenjian_client->startCrawlerPublish($app_id, $params);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}

/**
 * 停止爬虫应用的自动发布
 *
 * @param ShenjianClient $shenjian_client
 * @param $app_id
 */
function stopCrawlerPublish($shenjian_client, $app_id){
    try{
        $shenjian_client->stopCrawlerPublish($app_id);
    }catch (ShenjianException $e){
        Common::println(__FUNCTION__ . ": FAILED");
        Common::println($e->getMessage());
        return;
    }
    Common::println(__FUNCTION__ . ": OK");
}