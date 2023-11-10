<?php

namespace Elasticsearch\Endpoints\Cat;

use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class FieldData
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Cat
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class FieldData extends AbstractEndpoint
{
    private $fields;

    /**
     * @param $fields
     *
     * @return $this
     */
    public function setFields($fields)
    {
        if (!isset($fields)) {
            return $this;
        }

        $this->fields = $fields;

        return $this;
    }

    /**
     * @return string
     */
    protected function getURI()
    {
        $fields = $this->fields;
        $uri = "/_cat/fielddata";

        if (isset($fields)) {
            $uri = "/_cat/fielddata/$fields";
        }

        return $uri;
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'bytes',
            'local',
            'master_timeout',
            'h',
            'help',
            'v',
            'fields',
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
