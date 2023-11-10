<?php

namespace Elasticsearch\Endpoints;

use Elasticsearch\Common\Exceptions;

/**
 * Class Delete
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Delete extends AbstractEndpoint
{
    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->id === null) {
            throw new Exceptions\RuntimeException(
                'id is required for Delete'
            );
        }
        if ($this->index === null) {
            throw new Exceptions\RuntimeException(
                'index is required for Delete'
            );
        }
        if ($this->type === null) {
            throw new Exceptions\RuntimeException(
                'type is required for Delete'
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
            'consistency',
            'parent',
            'refresh',
            'replication',
            'routing',
            'timeout',
            'version',
            'version_type',
        ];
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'DELETE';
    }
}
