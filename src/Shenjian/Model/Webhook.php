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


class Webhook
{
    private $url;
    private $events;
    private $gzip;

    /**
     * @param string $url
     */
    public function setUrl($url){
        $this->url = $url;
    }

    /**
     * @param array $events
     */
    public function setEvents($events){
        $this->events = $events;
    }

    /**
     * @param boolean $boolean
     */
    public function setGzip($boolean){
        $this->gzip = $boolean;
    }

    /**
     * @return string | mixed
     */
    public function getUrl(){
        return $this->url;
    }

    /**
     * @return WebhookEventType[] | mixed
     */
    public function getEvents(){
        return $this->events;
    }

    public function getGzip(){
        return $this->gzip;
    }
}