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

namespace Shenjian\Model;


class App
{
    private $app_id;
    private $info;
    private $name;
    private $type;
    private $status;
    private $time_create;

    /**
     * @param int $app_id
     */
    public function setAppId($app_id){
        $this->app_id = $app_id;
    }

    /**
     * @param string $info
     */
    public function setInfo($info){
        $this->info = $info;
    }

    /**
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * @param AppType $type
     */
    public function setType($type){
        $this->type = $type;
    }

    /**
     * @param AppStatus $status
     */
    public function setStatus($status){
        $this->status = $status;
    }

    /**
     * @param int $time_create
     */
    public function setTimeCreate($time_create){
        $this->time_create = $time_create;
    }

    public function getAppId(){
        return $this->app_id;
    }
    
    public function getInfo(){
        return $this->info;
    }
    
    public function getName(){
        return $this->name;
    }

    public function getType(){
        return $this->type;
    }

    public function getStatus(){
        return $this->status;
    }

    public function getTimeCreate(){
        return $this->time_create;
    }
}