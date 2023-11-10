<?php

namespace Elasticsearch\Endpoints\Indices;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Get
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Get
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Get extends AbstractEndpoint
{
    private $feature;

    public function setFeature($feature)
    {
        if (!isset($feature)) {
            return $this;
        }

        if (is_array($feature)) {
            $feature = implode(",", $feature);
        }

        $this->feature = $feature;

        return $this;
    }

    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->index === null) {
            throw new Exceptions\RuntimeException(
                'index is required for Get'
            );
        }
        $index = $this->index;
        $feature = $this->feature;
        $uri = "/$index";

        if (isset($feature)) {
            $uri = "/$index/$feature";
        }

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'local',
            'ignore_unavailable',
            'allow_no_indices',
            'expand_wildcards',
            'flat_settings',
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
