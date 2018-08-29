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


class Node
{
    private $node_all;
    private $node_running;
    private $node_left;
    private $node_gpu_all;
    private $node_gpu_running;

    public function setNodeAll($node_all){
        $this->node_all = $node_all;
    }

    /**
     * @param int $node_running
     */
    public function setNodeRunning($node_running){
        $this->node_running = $node_running;
    }

    /**
     * @param int $node_left
     */
    public function setNodeLeft($node_left){
        $this->node_left = $node_left;
    }

    /**
     * @param int $node_gpu_all
     */
    public function setNodeGpuAll($node_gpu_all){
        $this->node_gpu_all = $node_gpu_all;
    }

    /**
     * @param int $node_gpu_running
     */
    public function setNodeGpuRunning($node_gpu_running){
        $this->node_gpu_running = $node_gpu_running;
    }

    public function getNodeAll(){
        return $this->node_all;
    }

    public function getNodeRunning(){
        return $this->node_running;
    }

    public function getNodeLeft(){
        return $this->node_left;
    }

    public function getNodeGpuAll(){
        return $this->node_gpu_all;
    }

    public function getNodeGpuRunning(){
        return $this->node_gpu_running;
    }
}