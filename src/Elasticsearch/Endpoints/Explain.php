<?php

namespace Elasticsearch\Endpoints;

use Elasticsearch\Common\Exceptions;

/**
 * Class Explain
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Explain extends AbstractEndpoint
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
                'id is required for Explain'
            );
        }
        if ($this->index === null) {
            throw new Exceptions\RuntimeException(
                'index is required for Explain'
            );
        }
        if ($this->type === null) {
            throw new Exceptions\RuntimeException(
                'type is required for Explain'
            );
        }
        $id = $this->id;
        $index = $this->index;
        $type = $this->type;
        $uri = "/$index/$type/$id/_explain";

        if (isset($index) && isset($type) && isset($id)) {
            $uri = "/$index/$type/$id/_explain";
        }

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'analyze_wildcard',
            'analyzer',
            'default_operator',
            'df',
            'fields',
            'lenient',
            'lowercase_expanded_terms',
            'parent',
            'preference',
            'q',
            'routing',
            'source',
            '_source',
            '_source_exclude',
            '_source_include',
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
