<?php

namespace Elasticsearch\Endpoints\Snapshot;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class VerifyRepository
 *
 * @category Elasticsearch
 * @package Elasticsearch\Endpoints\Snapshot *
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class VerifyRepository extends AbstractEndpoint
{
    // A repository name
    private $repository;


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
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->repository === null) {
            throw new Exceptions\RuntimeException(
                'repository is required for VerifyRepository'
            );
        }
        $repository = $this->repository;

        return "/_snapshot/$repository/_verify";
    }


    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'master_timeout',
            'timeout',
            'local',
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
