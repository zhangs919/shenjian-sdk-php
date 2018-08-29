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
use Shenjian\Model\AppCleaner;

class AppCleanerListResult extends Result
{
    protected function parseDataFromResponse(){
        $content = $this->data;
        if(!(is_array($content) && isset($content['list']) && count($content['list']))){
            throw new ShenjianException("AppList is empty");
        }
        $cleaner_list = array();
        foreach ($content['list'] as $unit){
            $cleaner = new AppCleaner();
            $cleaner->setAppId($unit['app_id']);
            $cleaner->setInfo($unit['info']);
            $cleaner->setName($unit['name']);
            $cleaner->setType($unit['type']);
            $cleaner->setStatus($unit['status']);
            $cleaner->setTimeCreate($unit['time_create']);
            $cleaner_list[] = $cleaner;
        }
        return $cleaner_list;
    }

}