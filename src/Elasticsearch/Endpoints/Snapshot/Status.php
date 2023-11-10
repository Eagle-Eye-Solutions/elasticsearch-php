<?php

namespace Elasticsearch\Endpoints\Snapshot;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Status
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Snapshot
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Status extends AbstractEndpoint
{
    // A comma-separated list of repository names
    private $repository;

    // A comma-separated list of snapshot names
    private $snapshot;

    /**
     * @param $repository
     *
     * @return $this
     */
    public function setRepository($repository)
    {
        if (!isset($repository)) {
            return $this;
        }

        $this->repository = $repository;

        return $this;
    }

    /**
     * @param $snapshot
     *
     * @return $this
     */
    public function setSnapshot($snapshot)
    {
        if (!isset($snapshot)) {
            return $this;
        }

        $this->snapshot = $snapshot;

        return $this;
    }

    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->snapshot !== null && $this->repository === null) {
            throw new Exceptions\RuntimeException(
                'Repository param must be provided if snapshot param is set'
            );
        }

        $repository = $this->repository;
        $snapshot = $this->snapshot;
        $uri = "/_snapshot/_status";

        if (isset($repository)) {
            $uri = "/_snapshot/$repository/_status";
        } elseif (isset($repository) && isset($snapshot)) {
            $uri = "/_snapshot/$repository/$snapshot/_status";
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
        return 'GET';
    }
}
