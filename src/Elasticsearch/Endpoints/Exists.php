<?php

namespace Elasticsearch\Endpoints;

use Elasticsearch\Common\Exceptions;

/**
 * Class Exists
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Exists extends AbstractEndpoint
{
    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->id === null) {
            throw new Exceptions\RuntimeException(
                'id is required for Exists'
            );
        }
        if ($this->index === null) {
            throw new Exceptions\RuntimeException(
                'index is required for Exists'
            );
        }
        if ($this->type === null) {
            throw new Exceptions\RuntimeException(
                'type is required for Exists'
            );
        }
        $id = $this->id;
        $index = $this->index;
        $type = $this->type;
        $uri = "/$index/$type/$id";

        if (isset($index) && isset($type) && isset($id)) {
            $uri = "/$index/$type/$id";
        }

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'parent',
            'preference',
            'realtime',
            'refresh',
            'routing',
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
