<?php

namespace Elasticsearch\Endpoints\Indices\Settings;

use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Get
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Indices\Settings
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Get extends AbstractEndpoint
{
    // The name of the settings that should be included
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
        $uri = "/_settings";

        if (isset($index) && isset($name)) {
            $uri = "/$index/_settings/$name";
        } elseif (isset($name)) {
            $uri = "/_settings/$name";
        } elseif (isset($index)) {
            $uri = "/$index/_settings";
        }

        return $uri;
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
            'flat_settings',
            'local',
            'human',
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
