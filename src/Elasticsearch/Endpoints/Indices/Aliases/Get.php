<?php

namespace Elasticsearch\Endpoints\Indices\Aliases;

use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Get
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Indices\Aliases
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Get extends AbstractEndpoint
{
    // A comma-separated list of alias names to filter
    private $name;

    /**
     * @param $name
     *
     * @return $this
     */
    public function setName($name)
    {
        if (!isset($name)) {
            return $this;
        }

        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    protected function getURI()
    {
        $index = $this->index;
        $name = $this->name;
        $uri = "/_aliases";

        if (isset($index) && isset($name)) {
            $uri = "/$index/_aliases/$name";
        } elseif (isset($name)) {
            $uri = "/_aliases/$name";
        } elseif (isset($index)) {
            $uri = "/$index/_aliases";
        }

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'timeout',
            'local',
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
