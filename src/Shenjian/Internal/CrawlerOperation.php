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

namespace Shenjian\Internal;


use Shenjian\Result\AppCrawlerListResult;
use Shenjian\Result\AppCrawlerResult;
use Shenjian\Result\AppSourceResult;
use Shenjian\Result\EditDeleteResult;
use Shenjian\Result\GetAppNodeResult;
use Shenjian\Result\GetPublishStatusResult;
use Shenjian\Result\GetSpeedResult;
use Shenjian\Result\GetStatusResult;
use Shenjian\Result\GetWebhookResult;
use Shenjian\Result\CopyCrawlerResult;

class CrawlerOperation extends CommonOperation
{

    /**
     * 获取爬虫应用列表
     *
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getList($params = null){
        $path = "crawler/list";
        $response = $this->doRequest($path, $params);
        $result = new AppCrawlerListResult($response);
        return $result->getData();
    }

    /**
     * 创建爬虫应用
     *
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function create($params){
        $path = "crawler/create";
        $response = $this->doRequest($path, $params);
        $result = new AppCrawlerResult($response);
        return $result->getData();
    }

    /**
     * 删除爬虫应用
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function delete($app_id){
        $path = "crawler/{$app_id}/delete";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 复制爬虫应用
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function copy($app_id){
        $path = "crawler/{$app_id}/copy";
        $response = $this->doRequest($path);
        $result = new CopyCrawlerResult($response);
        return $result->getData();
    }

    /**
     * 修改爬虫应用信息
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function edit($app_id, $params){
        $path = "crawler/{$app_id}/edit";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 获取爬虫应用的自定义项
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configCustomGet($app_id){
        $path = "crawler/{$app_id}/config/custom/get";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 设置爬虫应用的自定义项
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configCustom($app_id, $params){
        $path = "crawler/{$app_id}/config/custom";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 启动爬虫应用
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return string
     * @throws \Shenjian\Core\ShenjianException
     */
    public function start($app_id, $params = null){
        $path = "crawler/{$app_id}/start";
        $response = $this->doRequest($path, $params);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 停止爬虫应用
     *
     * @param int $app_id
     * @return string
     * @throws \Shenjian\Core\ShenjianException
     */
    public function stop($app_id){
        $path = "crawler/{$app_id}/stop";
        $response = $this->doRequest($path);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 暂停爬虫应用
     *
     * @param int $app_id
     * @return string
     * @throws \Shenjian\Core\ShenjianException
     */
    public function pause($app_id){
        $path = "crawler/{$app_id}/pause";
        $response = $this->doRequest($path);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 继续爬虫应用
     *
     * @param int $app_id
     * @return string
     * @throws \Shenjian\Core\ShenjianException
     */
    public function resume($app_id){
        $path = "crawler/{$app_id}/resume";
        $response = $this->doRequest($path);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 获取爬虫应用的状态
     *
     * @param int $app_id
     * @return string
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getStatus($app_id){
        $path = "crawler/{$app_id}/status";
        $response = $this->doRequest($path);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 获取爬虫应用的速率
     *
     * @param int $app_id
     * @return float|int
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getSpeed($app_id){
        $path = "crawler/{$app_id}/speed";
        $response = $this->doRequest($path);
        $result = new GetSpeedResult($response);
        return $result->getData();
    }

    /**
     * 修改爬虫应用的运行节点
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function changeNode($app_id, $params = null){
        $path = "crawler/{$app_id}/node";
        $response = $this->doRequest($path, $params);
        $result = new GetAppNodeResult($response);
        return $result->getData();
    }

    /**
     * 获取爬虫应用的数据信息
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getSource($app_id){
        $path = "crawler/{$app_id}/source";
        $response = $this->doRequest($path);
        $result = new AppSourceResult($response);
        return $result->getData();
    }

    /**
     * 清空爬虫数据
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function sourceClear($app_id){
        $path = "crawler/{$app_id}/source/clear";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 删除爬虫数据
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function sourceDelete($app_id, $params){
        $path = "crawler/{$app_id}/source/delete";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 设置爬虫应用的代理
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configProxy($app_id, $params){
        $path = "crawler/{$app_id}/config/proxy";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 设置爬虫遵守Robots协议
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configRobotsAgree($app_id){
        $path = "crawler/{$app_id}/config/robots/agree";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 设置爬虫不遵守Robots协议
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configRobotsDisagree($app_id){
        $path = "crawler/{$app_id}/config/robots/disagree";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 设置爬虫应用的托管
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configHost($app_id, $params){
        $path = "crawler/{$app_id}/config/host";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 获取爬虫应用的Webhook设置
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getWebhook($app_id){
        $path = "crawler/{$app_id}/webhook/get";
        $response = $this->doRequest($path);
        $result = new GetWebhookResult($response);
        return $result->getData();
    }

    /**
     * 删除爬虫应用的Webhook
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function deleteWebhook($app_id){
        $path = "crawler/{$app_id}/webhook/delete";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 修改爬虫应用的Webhook
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function setWebhook($app_id, $params){
        $path = "crawler/{$app_id}/webhook/set";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 获取爬虫应用的自动发布状态
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getPublishStatus($app_id){
        $path = "crawler/{$app_id}/autopublish/status";
        $response = $this->doRequest($path);
        $result = new GetPublishStatusResult($response);
        return $result->getData();
    }

    /**
     * 开启爬虫应用的自动发布
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function startPublish($app_id, $params){
        $path = "crawler/{$app_id}/autopublish/start";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 停止爬虫应用的自动发布
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function stopPublish($app_id){
        $path = "crawler/{$app_id}/autopublish/stop";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }
}