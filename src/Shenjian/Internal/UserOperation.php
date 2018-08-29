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


use Shenjian\Result\GetMoneyResult;
use Shenjian\Result\GetUserNodeResult;

class UserOperation extends CommonOperation
{

    /**
     * 获取账号余额
     *
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getMoney(){
        $path = "user/money";
        $response = $this->doRequest($path);
        $result = new GetMoneyResult($response);
        return $result->getData();
    }

    /**
     * 获取node信息
     *
     * @return mixed
     * @throws \Shenjian\Core\ShenjianException
     */
    public function getNode(){
        $path = "user/node";
        $response = $this->doRequest($path);
        $result = new GetUserNodeResult($response);
        return $result->getData();
    }
}