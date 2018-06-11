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


class Custom
{
    private $key;
    private $name;
    private $type;
    private $cvalue;
    
    /**
     * @param string $key
     */
    public function setKey($key){
        $this->key = $key;
    }

    /**
     * @param string $name
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * @param string $type
     */
    public function setType($type){
        $this->type = $type;
    }

    /**
     * @param $cvalue
     */
    public function setCvalue($cvalue){
        $this->cvalue = $cvalue;
    }

    /**
     * @return string | mixed
     */
    public function getKey(){
        return $this->key;
    }

    /**
     * @return string | mixed
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @return string mixed
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getCvalue(){
        if(is_array($this->cvalue)){
            return json_encode($this->cvalue);
        }
        return $this->cvalue;
    }
}