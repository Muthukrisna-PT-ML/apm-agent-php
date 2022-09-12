<?php

/*
 * Licensed to Elasticsearch B.V. under one or more contributor
 * license agreements. See the NOTICE file distributed with
 * this work for additional information regarding copyright
 * ownership. Elasticsearch B.V. licenses this file to you under
 * the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License.
 * You may obtain a copy of the License at
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

declare(strict_types=1);

namespace ElasticApmTests\Util;

/**
 * @template TDataExpectations of DataExpectationsBase
 */
abstract class DataExpectationsBuilder
{
    /** @var TDataExpectations */
    public $shared;

    /**
     * @param TDataExpectations $shared
     */
    public function __construct(DataExpectationsBase $shared)
    {
        $this->shared = $shared;
    }

    /**
     * @param TDataExpectations $expectations
     */
    protected function copyFromSharedTo($expectations): void
    {
        foreach (get_object_vars($this->shared) as $propName => $propVal) {
            $expectations->{$propName} = self::deepClone($propVal);
        }
    }

    /**
     * @param mixed $val
     *
     * @return mixed
     */
    private static function deepClone($val)
    {
        if (!is_object($val)) {
            return $val;
        }

        $result = clone $val;
        foreach (get_object_vars($result) as $propName => $propVal) {
            $result->{$propName} = self::deepClone($propVal);
        }
        return $result;
    }
}
