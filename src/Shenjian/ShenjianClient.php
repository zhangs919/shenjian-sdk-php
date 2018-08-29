<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */

namespace Shenjian;

use Shenjian\Core\ShenjianException;
use Shenjian\Internal\Credentials;
use Shenjian\Internal\UserOperation;
use Shenjian\Internal\AppOperation;
use Shenjian\Internal\CrawlerOperation;
use Shenjian\Internal\CleanerOperation;
use Shenjian\Internal\ApiOperation;
use Shenjian\Model\App;
use Shenjian\Model\AppApi;
use Shenjian\Model\AppCleaner;
use Shenjian\Model\AppCrawler;
use Shenjian\Model\AppSource;
use Shenjian\Model\Custom;
use Shenjian\Model\Node;
use Shenjian\Model\Webhook;


class ShenjianClient
{
    private $credentials;
    private $user_operation;
    private $app_operation;
    private $crawler_operation;
    private $api_operation;


    public function __construct($user_key, $user_secret){
        $user_key = trim($user_key);
        $user_secret = trim($user_secret);
        if (empty($user_key)) {
            throw new ShenjianException("access key id is empty");
        }
        if (empty($user_secret)) {
            throw new ShenjianException("access key secret is empty");
        }
        $this->credentials = new Credentials($user_key, $user_secret);
        $this->user_operation = new UserOperation($this->credentials);
        $this->app_operation = new AppOperation($this->credentials);
        $this->crawler_operation = new CrawlerOperation($this->credentials);
        $this->cleaner_operation = new CleanerOperation($this->credentials);
        $this->api_operation = new ApiOperation($this->credentials);

        self::checkEnv();
    }

    /**
     * 用来检查sdk需要用的扩展是否打开
     *
     * @throws ShenjianException
     */
    public static function checkEnv()
    {
        if (function_exists('get_loaded_extensions')) {
            //检测curl扩展
            $enabled_extension = array("curl");
            $extensions = get_loaded_extensions();
            if ($extensions) {
                foreach ($enabled_extension as $item) {
                    if (!in_array($item, $extensions)) {
                        throw new ShenjianException("Extension {" . $item . "} is not installed or not enabled, please check your php env.");
                    }
                }
            } else {
                throw new ShenjianException("function get_loaded_extensions not found.");
            }
        } else {
            throw new ShenjianException('Function get_loaded_extensions has been disabled, please check php config.');
        }
    }


    /*----------------------- begin user---------------------------*/


    /**
     * 获取账号余额
     *
     * @return mixed
     */
    public function getMoney(){
        return $this->user_operation->getMoney();
    }

    /**
     * 获取node信息
     *
     * @return Node | mixed
     */
    public function getNode(){
        return $this->user_operation->getNode();
    }


    /*----------------------- begin app---------------------------*/


    /**
     * 获取应用列表
     *
     * @param array $params
     * @return App[] | mixed
     */
    public function getAppList($params = null){
        return $this->app_operation->getAppList($params);
    }


    /*----------------------- begin crawler---------------------------*/


    /**
     * 获取爬虫应用列表
     *
     * @param null $params
     * @return AppCrawler[] | mixed
     */
    public function getCrawlerList($params = null){
        return $this->crawler_operation->getList($params);
    }

    /**
     * 创建爬虫应用
     *
     * @param array $params
     * @return AppCrawler | mixed
     */
    public function createCrawler($params){
        return $this->crawler_operation->create($params);
    }

    /**
     * 删除爬虫应用
     *
     * @param int $app_id
     * @return mixed
     */
    public function deleteCrawler($app_id){
        return $this->crawler_operation->delete($app_id);
    }

    /**
     * 复制爬虫应用
     *
     * @param int $app_id
     * @return int
     */
    public function copyCrawler($app_id){
        return $this->crawler_operation->copy($app_id);
    }

    /**
     * 修改爬虫应用信息
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function editCrawler($app_id, $params){
        return $this->crawler_operation->edit($app_id, $params);
    }

    /**
     * 获取爬虫应用的自定义项
     *
     * @param int $app_id
     * @return Custom[] | string | mixed
     */
    public function configCrawlerCustomGet($app_id){
        return $this->crawler_operation->configCustomGet($app_id);
    }

    /**
     * 设置爬虫应用的自定义项
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function configCrawlerCustom($app_id, $params){
        return $this->crawler_operation->configCustom($app_id, $params);
    }

    /**
     * 启动爬虫应用
     *
     * @param int $app_id
     * @param array $params
     * @return string
     */
    public function startCrawler($app_id, $params = null){
        return $this->crawler_operation->start($app_id, $params);
    }

    /**
     * 停止爬虫应用
     *
     * @param int $app_id
     * @return string
     */
    public function stopCrawler($app_id){
        return $this->crawler_operation->stop($app_id);
    }

    /**
     * 暂停爬虫应用
     *
     * @param int $app_id
     * @return string
     */
    public function pauseCrawler($app_id){
        return $this->crawler_operation->pause($app_id);
    }

    /**
     * 继续爬虫应用
     *
     * @param int $app_id
     * @return string
     */
    public function resumeCrawler($app_id){
        return $this->crawler_operation->resume($app_id);
    }

    /**
     * 获取爬虫应用的状态
     *
     * @param int $app_id
     * @return string
     */
    public function getCrawlerStatus($app_id){
        return $this->crawler_operation->getStatus($app_id);
    }

    /**
     * 获取爬虫应用的速率
     *
     * @param int $app_id
     * @return float|int
     */
    public function getCrawlerSpeed($app_id){
        return $this->crawler_operation->getSpeed($app_id);
    }

    /**
     * 修改爬虫应用的运行节点
     *
     * @param int $app_id
     * @param array $params
     * @return Node | mixed
     */
    public function changeCrawlerNode($app_id, $params = null){
        return $this->crawler_operation->changeNode($app_id, $params);
    }

    /**
     * 获取爬虫应用的数据信息
     *
     * @param int $app_id
     * @return AppSource | mixed
     */
    public function getCrawlerSource($app_id){
        return $this->crawler_operation->getSource($app_id);
    }

    /**
     * 清空爬虫数据
     *
     * @param int $app_id
     * @return mixed
     */
    public function clearCrawlerSource($app_id){
        return $this->crawler_operation->sourceClear($app_id);
    }

    /**
     * 删除爬虫数据
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function deleteCrawlerSource($app_id, $params){
        return $this->crawler_operation->sourceDelete($app_id, $params);
    }

    /**
     * 设置爬虫应用的代理
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function configCrawlerProxy($app_id, $params){
        return $this->crawler_operation->configProxy($app_id, $params);
    }

    /**
     * 设置爬虫遵守Robots协议
     *
     * @param int $app_id
     * @return void
     */
    public function configCrawlerRobotsAgree($app_id) {
        $this->crawler_operation->configRobotsAgree($app_id);
    }

    /**
     * 设置爬虫不遵守Robots协议
     *
     * @param int $app_id
     * @return void
     */
    public function configCrawlerRobotsDisagree($app_id) {
        $this->crawler_operation->configRobotsDisagree($app_id);
    }

    /**
     * 设置爬虫应用的托管
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function configCrawlerHost($app_id, $params){
        return $this->crawler_operation->configHost($app_id, $params);
    }

    /**
     * 获取爬虫应用的Webhook设置
     *
     * @param int $app_id
     * @return Webhook | mixed
     */
    public function getCrawlerWebhook($app_id){
        return $this->crawler_operation->getWebhook($app_id);
    }

    /**
     * 删除爬虫应用的Webhook
     *
     * @param int $app_id
     * @return mixed
     */
    public function deleteCrawleWebhook($app_id){
        return $this->crawler_operation->deleteWebhook($app_id);
    }

    /**
     * 修改爬虫应用的Webhook
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function setCrawlerWebhook($app_id, $params){
        return $this->crawler_operation->setWebhook($app_id, $params);
    }

    /**
     * 获取爬虫应用的自动发布状态
     *
     * @param int $app_id
     * @return mixed
     */
    public function getCrawlerPublishStatus($app_id){
        return $this->crawler_operation->getPublishStatus($app_id);
    }

    /**
     * 开启爬虫应用的自动发布
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function startCrawlerPublish($app_id, $params){
        return $this->crawler_operation->startPublish($app_id, $params);
    }

    /**
     * 停止爬虫应用的自动发布
     *
     * @param int $app_id
     * @return mixed
     */
    public function stopCrawlerPublish($app_id){
        return $this->crawler_operation->stopPublish($app_id);
    }


    /*----------------------- begin cleaner---------------------------*/


    /**
     * 获取清洗应用列表
     *
     * @param array $params
     * @return AppCleaner[] | mixed
     */
    public function getCleanerList($params = null){
        return $this->cleaner_operation->getList($params);
    }

    /**
     * 创建清洗应用
     *
     * @param array $params
     * @return AppCleaner | mixed
     */
    public function createCleaner($params){
        return $this->cleaner_operation->create($params);
    }

    /**
     * 删除清洗应用
     * 
     * @param int $app_id
     * @return mixed
     */
    public function deleteCleaner($app_id){
        return $this->cleaner_operation->delete($app_id);
    }

    /**
     * 修改清洗应用信息
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function editCleaner($app_id, $params){
        return $this->cleaner_operation->edit($app_id, $params);
    }

    /**
     * 设置清洗应用的代理
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function configCleanerProxy($app_id, $params){
        return $this->cleaner_operation->configProxy($app_id, $params);
    }

    /**
     * 配置清洗应用的文件云托管
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function configCleanerHost($app_id, $params){
        return $this->cleaner_operation->configHost($app_id, $params);
    }

    /**
     * 设置清洗应用的输入数据源和输出数据源
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function configCleanerSource($app_id, $params){
        return $this->cleaner_operation->configSource($app_id, $params);
    }

    /**
     * 启动清洗应用
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function startCleaner($app_id, $params = null){
        return $this->cleaner_operation->start($app_id, $params);
    }

    /**
     * 停止清洗应用
     *
     * @param int $app_id
     * @return mixed
     */
    public function stopCleaner($app_id){
        return $this->cleaner_operation->stop($app_id);
    }

    /**
     * 暂停清洗应用
     *
     * @param int $app_id
     * @return mixed
     */
    public function pauseCleaner($app_id){
        return $this->cleaner_operation->pause($app_id);
    }

    /**
     * 继续清洗应用
     *
     * @param int $app_id
     * @return mixed
     */
    public function resumeCleaner($app_id){
        return $this->cleaner_operation->resume($app_id);
    }

    /**
     * 获取清洗应用的状态
     *
     * @param int $app_id
     * @return mixed
     */
    public function getCleanerStatus($app_id){
        return $this->cleaner_operation->getStatus($app_id);
    }

    /**
     * 获取清洗应用的Webhook
     *
     * @param int $app_id
     * @return Webhook | mixed
     */
    public function getCleanerWebhook($app_id){
        return $this->cleaner_operation->getWebhook($app_id);
    }

    /**
     * 设置清洗应用的Webhook
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function setCleanerWebhook($app_id, $params){
        return $this->cleaner_operation->setWebhook($app_id, $params);
    }

    /**
     * 删除清洗应用的Webhook
     *
     * @param int $app_id
     * @return mixed
     */
    public function deleteCleanerWebhook($app_id){
        return $this->cleaner_operation->deleteWebhook($app_id);
    }


    /*----------------------- begin api---------------------------*/


    /**
     * 获取API应用列表
     *
     * @param array $params
     * @return AppApi[] | mixed
     */
    public function getApiList($params = null){
        return $this->api_operation->getList($params);
    }

    /**
     * 创建API应用
     *
     * @param array $params
     * @return AppApi | mixed
     */
    public function createApi($params){
        return $this->api_operation->create($params);
    }

    /**
     * 删除API应用
     *
     * @param int $app_id
     * @return mixed
     */
    public function deleteApi($app_id){
        return $this->api_operation->delete($app_id);
    }

    /**
     * 修改API应用信息
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function editApi($app_id, $params){
        return $this->api_operation->edit($app_id, $params);
    }

    /**
     * 配置API应用的代理
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function configApiProxy($app_id, $params){
        return $this->api_operation->configProxy($app_id, $params);
    }

    /**
     * 配置API应用的文件云托管
     *
     * @param int $app_id
     * @param array $params
     * @return mixed
     */
    public function configApiHost($app_id, $params){
        return $this->api_operation->configHost($app_id, $params);
    }

    /**
     * 获取API应用的调用key
     *
     * @param int $app_id
     * @return mixed
     */
    public function getApiKey($app_id){
        return $this->api_operation->getKey($app_id);
    }
}