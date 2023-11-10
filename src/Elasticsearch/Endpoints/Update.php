<?php

namespace Elasticsearch\Endpoints;

use Elasticsearch\Common\Exceptions;

/**
 * Class Update
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Update extends AbstractEndpoint
{
    /**
     * @param array $body
     *
     * @throws \Elasticsearch\Common\Exceptions\InvalidArgumentException
     * @return $this
     */
    public function setBody($body)
    {
        if (!isset($body)) {
            return $this;
        }

        $this->body = $body;

        return $this;
    }

    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->id === null) {
            throw new Exceptions\RuntimeException(
                'id is required for Update'
            );
        }
        if ($this->index === null) {
            throw new Exceptions\RuntimeException(
                'index is required for Update'
            );
        }
        if ($this->type === null) {
            throw new Exceptions\RuntimeException(
                'type is required for Update'
            );
        }
        $id = $this->id;
        $index = $this->index;
        $type = $this->type;
        $uri = "/$index/$type/$id/_update";

        if (isset($index) && isset($type) && isset($id)) {
            $uri = "/$index/$type/$id/_update";
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
            'fields',
            'lang',
            'parent',
            'refresh',
            'replication',
            'retry_on_conflict',
            'routing',
            'script',
            'script_id',
            'scripted_upsert',
            'timeout',
            'timestamp',
            'ttl',
            'version',
            'version_type',
        ];
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'POST';
    }
}
