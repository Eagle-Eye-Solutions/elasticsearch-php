<?php

namespace Elasticsearch\Endpoints\Script;

use Elasticsearch\Common\Exceptions;
use Elasticsearch\Endpoints\AbstractEndpoint;

/**
 * Class Delete
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints\Script
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
class Delete extends AbstractEndpoint
{
    /** @var  String */
    private $lang;

    /**
     * @param $lang
     *
     * @return $this
     */
    public function setLang($lang)
    {
        if (!isset($lang)) {
            return $this;
        }

        $this->lang = $lang;

        return $this;
    }

    /**
     * @throws \Elasticsearch\Common\Exceptions\RuntimeException
     * @return string
     */
    protected function getURI()
    {
        if ($this->lang === null) {
            throw new Exceptions\RuntimeException(
                'lang is required for Put'
            );
        }
        if ($this->id === null) {
            throw new Exceptions\RuntimeException(
                'id is required for put'
            );
        }
        $id = $this->id;
        $lang = $this->lang;

        return "/_scripts/$lang/$id";
    }

    /**
     * @return string[]
     */
    protected function getParamWhitelist()
    {
        return [
            'version',
            'version_type',
        ];
    }

    /**
     * @return string
     */
    protected function getMethod()
    {
        return 'DELETE';
    }
}
