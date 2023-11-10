<?php

namespace Elasticsearch\Endpoints\Source;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Get
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Source
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Get extends AbstractEndpoint
{
    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->id === null) {
            throw new Exceptions\RuntimeException(
                'id is required for Get'
            );
        }
        if ($this->index === null) {
            throw new Exceptions\RuntimeException(
                'index is required for Get'
            );
        }
        if ($this->type === null) {
            throw new Exceptions\RuntimeException(
                'type is required for Get'
            );
        }
        $id = $this->id;
        $index = $this->index;
        $type = $this->type;
        $uri = "/$index/$type/$id/_source";

        if (isset($index) && isset($type) && isset($id)) {
            $uri = "/$index/$type/$id/_source";
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
            '_source',
            '_source_exclude',
            '_source_include',
            'version',
            'version_type',
        ];
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'GET';
    }
}
