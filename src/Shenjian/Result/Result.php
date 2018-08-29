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

namespace Shenjian\Result;

use Shenjian\Core\ShenjianException;
use Shenjian\Http\ResponseCore;


/**
 * Class Result, 操作结果类的基类，不同的请求在处理返回数据的时候有不同的逻辑，
 * 具体的解析逻辑推迟到子类实现
 *
 * @package Shenjian\Model
 */
abstract class Result
{
    /**
     * 标示请求是否成功
     */
    protected $isOk = false;
    /**
     * 由子类解析过的数据
     */
    protected $parsedData = null;
    /**
     * 存放doRequest函数返回的原始Response
     *
     * @var ResponseCore
     */
    protected $rawResponse;

    protected $code;
    protected $reason;
    protected $data;


    /**
     * Result constructor.
     * @param $response ResponseCore
     * @throws ShenjianException
     */
    public function __construct($response)
    {
        if ($response === null) {
            throw new ShenjianException("raw response is null");
        }
        $this->rawResponse = $response;
        $body = json_decode($response->body, true);
        $this->code = $body['code'];
        $this->reason = $body['reason'];
        $this->data = isset($body['data']) ? $body['data'] : null;
        $this->parseResponse();
    }

    /**
     * 得到返回数据，不同的请求返回数据格式不同
     *
     * $return mixed
     */
    public function getData()
    {
        return $this->parsedData;
    }

    /**
     * 由子类实现，不同的请求返回数据有不同的解析逻辑，由子类实现
     *
     * @return mixed
     */
    abstract protected function parseDataFromResponse();

    /**
     * 操作是否成功
     *
     * @return mixed
     */
    public function isOK()
    {
        return $this->isOk;
    }

    /**
     * @throws ShenjianException
     */
    public function parseResponse()
    {
        $this->isOk = $this->isResponseOk();
        if ($this->isOk) {
            $this->parsedData = $this->parseDataFromResponse();
        } else {
            $httpStatus = strval($this->rawResponse->status);
            $code = $this->code;
            $message = $this->reason;
            $body = $this->rawResponse->body;
            $details = array(
                'status' => $httpStatus,
                'code' => $code,
                'message' => $message,
                'body' => $body
            );
            throw new ShenjianException($details);
        }
    }

    /**
     * 根据返回http状态码判断，[200-299]即认为是OK
     *
     * @return bool
     */
    protected function isResponseOk()
    {
        $status = $this->rawResponse->status;
        if ((int)(intval($status) / 100) == 2 && $this->code == 0) {
            return true;
        }
        return false;
    }

    /**
     * 返回原始的返回数据
     *
     * @return ResponseCore
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }


}