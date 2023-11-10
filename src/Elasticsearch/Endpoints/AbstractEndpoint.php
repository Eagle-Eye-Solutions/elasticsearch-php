<?php

namespace Elasticsearch\Endpoints;

use Elasticsearch\Common\Exceptions\UnexpectedValueException;
use Elasticsearch\Transport;
use Exception;
use GuzzleHttp\Ring\Future\FutureArrayInterface;

/**
 * Class AbstractEndpoint
 *
 * @category Elasticsearch
 * @package  Elasticsearch\Endpoints
 * @author   Zachary Tong <zachary.tong@elasticsearch.com>
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache2
 * @link     http://elasticsearch.org
 */
abstract class AbstractEndpoint
{
    /** @var array */
    protected $params = [];

    /** @var  string */
    protected $index = null;

    /** @var  string */
    protected $type = null;

    /** @var  string|int */
    protected $id = null;

    /** @var  string */
    protected $method = null;

    /** @var  array */
    protected $body = null;

    /** @var \Elasticsearch\Transport */
    private $transport = null;

    /** @var array */
    private $options = [];

    /**
     * @return string[]
     */
    abstract protected function getParamWhitelist();

    /**
     * @return string
     */
    abstract protected function getURI();

    /**
     * @return string
     */
    abstract protected function getMethod();

    /**
     * @param Transport $transport
     */
    public function __construct($transport)
    {
        $this->transport = $transport;
    }

    /**
     * @throws \Exception
     * @return array
     */
    public function performRequest()
    {
        return $this->transport->performRequest(
            $this->getMethod(),
            $this->getURI(),
            $this->params,
            $this->getBody(),
            $this->options
        );
    }

    /**
     * Set the parameters for this endpoint
     *
     * @param string[] $params Array of parameters
     *
     * @return $this
     */
    public function setParams($params)
    {
        if (is_object($params)) {
            $params = (array)$params;
        }

        $this->checkUserParams($params);
        $params = $this->convertCustom($params);
        $this->extractOptions($params);
        $this->params = $this->convertArraysToStrings($params);

        return $this;
    }

    /**
     * @param string $index
     *
     * @return $this
     */
    public function setIndex($index)
    {
        if ($index === null) {
            return $this;
        }

        if (is_array($index)) {
            $index = array_map('trim', $index);
            $index = implode(",", $index);
        }

        $this->index = urlencode($index);

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        if ($type === null) {
            return $this;
        }

        if (is_array($type)) {
            $type = array_map('trim', $type);
            $type = implode(",", $type);
        }

        $this->type = urlencode($type);

        return $this;
    }

    /**
     * @param int|string $docID
     *
     * @return $this
     */
    public function setID($docID)
    {
        if ($docID === null) {
            return $this;
        }

        $this->id = urlencode($docID);

        return $this;
    }

    /**
     * @param $result
     *
     * @return callable|array
     */
    public function resultOrFuture($result)
    {
        $response = null;
        $async = isset($this->options['client']['future']) ? $this->options['client']['future'] : null;
        if (is_null($async) || $async === false) {
            do {
                $result = $result->wait();
            } while ($result instanceof FutureArrayInterface);

            return $result;
        } elseif ($async === true || $async === 'lazy') {
            return $result;
        }
    }

    /**
     * @return array
     */
    protected function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $endpoint
     *
     * @return string
     */
    protected function getOptionalURI($endpoint)
    {
        $uri = [];
        $uri[] = $this->getOptionalIndex();
        $uri[] = $this->getOptionalType();
        $uri[] = $endpoint;
        $uri = array_filter($uri);

        return '/' . implode('/', $uri);
    }

    /**
     * @return string
     */
    private function getOptionalIndex()
    {
        if ($this->index !== null) {
            return $this->index;
        } else {
            return '_all';
        }
    }

    /**
     * @return string
     */
    private function getOptionalType()
    {
        if ($this->type !== null) {
            return $this->type;
        } else {
            return '';
        }
    }

    /**
     * @param array $params
     *
     * @throws \Elasticsearch\Common\Exceptions\UnexpectedValueException
     */
    private function checkUserParams($params)
    {
        if (!isset($params)) {
            return; //no params, just return.
        }

        $whitelist = array_merge($this->getParamWhitelist(), ['client', 'custom', 'filter_path']);

        foreach (array_keys($params) as $key) {
            if (!in_array($key, $whitelist)) {
                throw new UnexpectedValueException(
                    sprintf(
                        '"%s" is not a valid parameter. Allowed parameters are: "%s"',
                        $key,
                        implode('", "', $whitelist)
                    )
                );
            }
        }
    }

    /**
     * @param $params       Note: this is passed by-reference!
     */
    private function extractOptions(&$params)
    {
        // Extract out client options, then start transforming
        if (isset($params['client'])) {
            $this->options['client'] = $params['client'];
            unset($params['client']);
        }

        $ignore = isset($this->options['client']['ignore']) ? $this->options['client']['ignore'] : null;
        if (isset($ignore)) {
            if (is_string($ignore)) {
                $this->options['client']['ignore'] = explode(",", $ignore);
            } elseif (is_array($ignore)) {
                $this->options['client']['ignore'] = $ignore;
            } else {
                $this->options['client']['ignore'] = [$ignore];
            }
        }
    }

    private function convertCustom($params)
    {
        if (isset($params['custom'])) {
            foreach ($params['custom'] as $k => $v) {
                $params[$k] = $v;
            }
            unset($params['custom']);
        }

        return $params;
    }

    private function convertArraysToStrings($params)
    {
        foreach ($params as $key => &$value) {
            if ($key !== 'client' && $key != 'custom' && is_array($value) && $this->isNestedArray($value) !== true) {
                $value = implode(",", $value);
            }
        }

        return $params;
    }

    private function isNestedArray($a)
    {
        foreach ($a as $v) {
            if (is_array($v)) {
                return true;
            }
        }

        return false;
    }
}
