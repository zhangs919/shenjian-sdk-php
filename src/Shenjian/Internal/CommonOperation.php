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

use Shenjian\Http\RequestCore;
use Shenjian\Http\RequestCoreException;
use Shenjian\Http\ResponseCore;
use Shenjian\Core\ShenjianException;

class CommonOperation
{
    //Shenjian 内部常量
    const SHENJIAN_REQUEST_BASE = 'http://www.shenjian.io/rest/v3/';
    const SHENJIAN_CONTROLLER = 'controller';
    const SHENJIAN_ACTION = 'action';
    const SHENJIAN_SUB_ACTION = 'sub_action';
    const SHENJIAN_USER_KEY = 'user_key';
    const SHENJIAN_TIMESTAMP = 'timestamp';
    const SHENJIAN_SIGN = 'sign';
    const SHENJIAN_NAME = 'Shenjian-sdk-php';
    const SHENJIAN_VERSION = '1.3';
    const SHENJIAN_APP_ID = 'app_id';

    protected $user_key;
    protected $timestamp;
    protected $sign;
    private $maxRetries = 3;
    private $redirects = 0;

    /**
     * CommonOperation constructor.
     * @param Credentials $credentials
     */
    public function __construct($credentials){
        $this->user_key = $credentials->user_key;
        $this->timestamp = $credentials->timestamp;
        $this->sign = $credentials->sign;
    }

    /**
     * @param string $path
     * @param array $params Key-Value数组
     * @return mixed
     * @throws ShenjianException
     */
    public function doRequest($path, $params = null){
        $request_url = self::SHENJIAN_REQUEST_BASE . $path;
        $request = new RequestCore($request_url);
        $request->set_method('post');
        $params[self::SHENJIAN_USER_KEY] = $this->user_key;
        $params[self::SHENJIAN_TIMESTAMP] = $this->timestamp;
        $params[self::SHENJIAN_SIGN] = $this->sign;
        $request->set_body($params);
        try {
            $request->send_request();
        } catch (RequestCoreException $e) {
            throw(new ShenjianException('RequestCoreException: ' . $e->getMessage()));
        }
        $response_header = $request->get_response_header();
        $data = new ResponseCore($response_header, $request->get_response_body(), $request->get_response_code());
        if ((integer)$request->get_response_code() === 500) {
            if ($this->redirects <= $this->maxRetries) {
                //设置休眠
                $delay = (integer)(pow(4, $this->redirects) * 100000);
                usleep($delay);
                $this->redirects++;
                $data = $this->doRequest($path, $params);
            }
        }
        $this->redirects = 0;
        return $data;
    }
}