<?php

namespace Elasticsearch\Endpoints\Indices\Mapping;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Delete
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Indices\Mapping
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
        $index = $this->index;
        $type = $this->type;
        $uri = "/$index/$type/_mapping";

        if (isset($index) && isset($type)) {
            $uri = "/$index/$type/_mapping";
        }

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'master_timeout',
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
