<?php

namespace Elasticsearch\Endpoints\Cat;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Snapshots
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Cat
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Snapshots extends AbstractEndpoint
{
    private $repository;

    /**
     * @param $fields
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
     * @return string
     */
    protected function getURI()
    {
        if ($this->repository === null) {
            throw new Exceptions\RuntimeException(
                'repository is required for Cat Snapshots '
            );
        }
        $repository = $this->repository;

        return "/_cat/snapshots/$repository/";
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'local',
            'ignore_unavailable',
            'master_timeout',
            'h',
            'help',
            'v',
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
