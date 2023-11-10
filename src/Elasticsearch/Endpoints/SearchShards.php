<?php

namespace Elasticsearch\Endpoints;

/**
 * Class Search
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class SearchShards extends AbstractEndpoint
{
    /**
     * @return string
     */
    protected function getURI()
    {
        $index = $this->index;
        $type = $this->type;
        $uri = "/_search_shards";

        if (isset($index) && isset($type)) {
            $uri = "/$index/$type/_search_shards";
        } elseif (isset($index)) {
            $uri = "/$index/_search_shards";
        } elseif (isset($type)) {
            $uri = "/_all/$type/_search_shards";
        }

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'preference',
            'routing',
            'local',
            'ignore_unavailable',
            'allow_no_indices',
            'expand_wildcards',
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
