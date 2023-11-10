<?php

namespace Elasticsearch\Endpoints;

use Elasticsearch\Common\Exceptions;

/**
 * Class Reindex
 *
 * @category Elasticsearch
 * @package Elasticsearch\Endpoints *
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Reindex extends AbstractEndpoint
{
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

        if (!is_array($body)) {
            throw new Exceptions\InvalidArgumentException(
                'Body must be an array'
            );
        }
        $this->body = $body;

        return $this;
    }


    /**
     * @return string
     */
    protected function getURI()
    {
        return "/_reindex";
    }


    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'refresh',
            'timeout',
            'consistency',
            'wait_for_completion',
        ];
    }


    /**
     * @return array
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     */
    protected function getBody()
    {
        if ($this->body === null) {
            throw new Exceptions\RuntimeException('Body is required for POST');
        }

        return $this->body;
    }


    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'POST';
    }
}
