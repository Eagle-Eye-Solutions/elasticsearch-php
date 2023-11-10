<?php

namespace Elasticsearch\Endpoints\Nodes;

/**
 * Class Stats
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Cluster\Nodes
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Stats extends AbstractNodesEndpoint
{
    // Limit the information returned to the specified metrics
    private $metric;

    // Limit the information returned for `indices` metric to the specific index metrics. Isn&#039;t used if `indices`
    // (or `all`) metric isn&#039;t specified.
    private $indexMetric;

    /**
     * @param $metric
     *
     * @return $this
     */
    public function setMetric($metric)
    {
        if (!isset($metric)) {
            return $this;
        }

        if (is_array($metric)) {
            $metric = implode(",", $metric);
        }

        $this->metric = $metric;

        return $this;
    }

    /**
     * @param $indexMetric
     *
     * @return $this
     */
    public function setIndexMetric($indexMetric)
    {
        if (!isset($indexMetric)) {
            return $this;
        }

        if (is_array($indexMetric)) {
            $indexMetric = implode(",", $indexMetric);
        }

        $this->indexMetric = $indexMetric;

        return $this;
    }

    /**
     * @return string
     */
    protected function getURI()
    {
        $metric = $this->metric;
        $index_metric = $this->indexMetric;
        $node_id = $this->nodeID;
        $uri = "/_nodes/stats";

        if (isset($node_id) && isset($metric) && isset($index_metric)) {
            $uri = "/_nodes/$node_id/stats/$metric/$index_metric";
        } elseif (isset($metric) && isset($index_metric)) {
            $uri = "/_nodes/stats/$metric/$index_metric";
        } elseif (isset($node_id) && isset($metric)) {
            $uri = "/_nodes/$node_id/stats/$metric";
        } elseif (isset($metric)) {
            $uri = "/_nodes/stats/$metric";
        } elseif (isset($node_id)) {
            $uri = "/_nodes/$node_id/stats";
        }

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'completion_fields',
            'fielddata_fields',
            'fields',
            'groups',
            'human',
            'level',
            'types',
            'timeout',
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
