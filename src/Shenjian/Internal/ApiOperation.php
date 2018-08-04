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

use Shenjian\Result\AppApiListResult;
use Shenjian\Result\AppApiResult;
use Shenjian\Result\EditDeleteResult;
use Shenjian\Result\GetAppApiKeyResult;

class ApiOperation extends CommonOperation
{

    /**
     * 获取API列表
     *
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getList($params = null){
        $path = "api/list";
        $response = $this->doRequest($path, $params);
        $result = new AppApiListResult($response);
        return $result->getData();
    }

    /**
     * 创建API
     *
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function create($params){
        $path = "api/create";
        $response = $this->doRequest($path, $params);
        $result = new AppApiResult($response);
        return $result->getData();
    }

    /**
     * 删除API
     *
     * @param int $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function delete($app_id){
        $path = "api/{$app_id}/delete";
        $response = $this->doRequest($path);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 修改API
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function edit($app_id, $params){
        $path = "api/{$app_id}/edit";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 配置代理
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configProxy($app_id, $params){
        $path = "api/{$app_id}/config/proxy";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 配置文件云托管
     *
     * @param int $app_id
     * @param array $params Key-Value数组
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function configHost($app_id, $params){
        $path = "api/{$app_id}/config/host";
        $response = $this->doRequest($path, $params);
        $result = new EditDeleteResult($response);
        return $result->getData();
    }

    /**
     * 获取API的调用key
     *
     * @param $app_id
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getKey($app_id){
        $path = "api/{$app_id}/key";
        $response = $this->doRequest($path);
        $result = new GetAppApiKeyResult($response);
        return $result->getData();
    }
}