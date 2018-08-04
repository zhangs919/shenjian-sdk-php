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

namespace Shenjian\Http;

/**
 * Container for all response-related methods.
 */
class ResponseCore
{
    /**
     * Stores the HTTP header information.
     */
    public $header;

    /**
     * Stores the SimpleXML response.
     */
    public $body;

    /**
     * Stores the HTTP response code.
     */
    public $status;

    /**
     * Constructs a new instance of this class.
     *
     * @param array $header (Required) Associative array of HTTP headers (typically returned by <RequestCore::get_response_header()>).
     * @param string $body (Required) XML-formatted response from AWS.
     * @param integer $status (Optional) HTTP response status code from the request.
     * @return Mixed Contains an <php:array> `header` property (HTTP headers as an associative array), a <php:SimpleXMLElement> or <php:string> `body` property, and an <php:integer> `status` code.
     */
    public function __construct($header, $body, $status = null)
    {
        $this->header = $header;
        $this->body = $body;
        $this->status = $status;

        return $this;
    }

    /**
     * Did we receive the status code we expected?
     *
     * @param integer|array $codes (Optional) The status code(s) to expect. Pass an <php:integer> for a single acceptable value, or an <php:array> of integers for multiple acceptable values.
     * @return boolean Whether we received the expected status code or not.
     */
    public function isOK($codes = array(200, 201, 204, 206))
    {
        if (is_array($codes)) {
            return in_array($this->status, $codes);
        }

        return $this->status === $codes;
    }
}