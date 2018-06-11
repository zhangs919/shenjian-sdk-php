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


class Credentials
{
    public $user_key;
    public $user_secret;
    public $timestamp;
    public $sign;

    /**
     * Credentials constructor
     * @param string $user_key
     * @param string $user_secret
     */
    public function __construct($user_key, $user_secret){
        $timestamp = time();
        $sign = strtolower(md5($user_key.$timestamp.$user_secret));
        $this->user_key  = $user_key;
        $this->timestamp = $timestamp;
        $this->sign = $sign;
    }
}