<?php

namespace Elasticsearch\Endpoints\Indices\Exists;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Types
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Indices\Exists
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Types extends AbstractEndpoint
{
    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->index === null) {
            throw new Exceptions\RuntimeException(
                'index is required for Types Exists'
            );
        }

        if ($this->type === null) {
            throw new Exceptions\RuntimeException(
                'type is required for Types Exists'
            );
        }

        $index = $this->index;
        $type = $this->type;

        return "/$index/$type";
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'ignore_unavailable',
            'allow_no_indices',
            'expand_wildcards',
            'local',
        ];
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'HEAD';
    }
}
