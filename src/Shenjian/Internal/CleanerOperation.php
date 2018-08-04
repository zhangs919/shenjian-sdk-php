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


use Shenjian\Result\AppCleanerListResult;
use Shenjian\Result\AppCleanerResult;
use Shenjian\Result\EditDeleteResult;
use Shenjian\Result\GetStatusResult;
use Shenjian\Result\GetWebhookResult;

class CleanerOperation extends CommonOperation
{

    /**
     * 获取清洗应用列表
     *
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getList($params = null){
        $path = "cleaner/list";
        $response = $this->doRequest($path, $params);
        $result = new AppCleanerListResult($response);
        return $result->getData();
    }

    /**
     * 创建清洗应用
     *
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function create($params){
        $path = "cleaner/create";
        $response = $this->doRequest($path, $params);
        $result = new AppCleanerResult($response);
        return $result->getData();
    }

    /**
     * 删除清洗应用
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function delete($app_id){
        $path = "cleaner/{$app_id}/delete";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 修改清洗应用信息
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function edit($app_id, $params){
        $path = "cleaner/{$app_id}/edit";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 设置清洗应用的代理
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configProxy($app_id, $params){
        $path = "cleaner/{$app_id}/config/proxy";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 配置清洗应用的文件云托管
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configHost($app_id, $params){
        $path = "cleaner/{$app_id}/config/host";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 设置清洗应用的输入数据源和输出数据源
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configSource($app_id, $params){
        $path = "cleaner/{$app_id}/config/source";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 启动清洗应用
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function start($app_id, $params = null){
        $path = "cleaner/{$app_id}/start";
        $response = $this->doRequest($path, $params);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 停止清洗应用
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function stop($app_id){
        $path = "cleaner/{$app_id}/stop";
        $response = $this->doRequest($path);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 暂停清洗应用
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function pause($app_id){
        $path = "cleaner/{$app_id}/pause";
        $response = $this->doRequest($path);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 继续清洗应用
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function resume($app_id){
        $path = "cleaner/{$app_id}/resume";
        $response = $this->doRequest($path);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 获取清洗应用的状态
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getStatus($app_id){
        $path = "cleaner/{$app_id}/status";
        $response = $this->doRequest($path);
        $result = new GetStatusResult($response);
        return $result->getData();
    }

    /**
     * 获取清洗应用的Webhook
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getWebhook($app_id){
        $path = "cleaner/{$app_id}/webhook/get";
        $response = $this->doRequest($path);
        $result = new GetWebhookResult($response);
        return $result->getData();
    }

    /**
     * 设置清洗应用的Webhook
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function setWebhook($app_id, $params){
        $path = "cleaner/{$app_id}/webhook/set";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 删除清洗应用的Webhook
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function deleteWebhook($app_id){
        $path = "cleaner/{$app_id}/webhook/delete";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }
}