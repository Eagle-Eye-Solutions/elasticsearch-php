<?php

namespace Elasticsearch\Endpoints\Snapshot;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Create
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Snapshot
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Create extends AbstractEndpoint
{
    // A repository name
    private $repository;

    // A snapshot name
    private $snapshot;

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
        if ($this->repository === null) {
            throw new Exceptions\RuntimeException(
                'repository is required for Create'
            );
        }
        if ($this->snapshot === null) {
            throw new Exceptions\RuntimeException(
                'snapshot is required for Create'
            );
        }
        $repository = $this->repository;
        $snapshot = $this->snapshot;
        $uri = "/_snapshot/$repository/$snapshot";

        if (isset($repository) && isset($snapshot)) {
            $uri = "/_snapshot/$repository/$snapshot";
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
            'wait_for_completion',
        ];
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'PUT';
    }
}
