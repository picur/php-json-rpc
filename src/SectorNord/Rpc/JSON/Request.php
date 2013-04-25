<?php
namespace SectorNord\Rpc\JSON;

class Request
{

    /** @var string */
    protected $method;

    /** @var array */
    protected $params;

    /** @var string */
    protected $id;

    function __construct($method, $params, $id = null)
    {
        $this->method = $method;
        $this->params = $params;
        $this->id = $id == null ? $this->createId() : $id;
    }

    /**
     * Creates a request ID
     *
     * @return string
     */
    protected function createId()
    {
        return time() . round(microtime() * 100000);
    }

    /**
     * Returns the RequestArray
     *
     * @return array
     */
    public function asArray()
    {
        return array('jsonrpc' => "2.0", 'method' => $this->method, 'params' => $this->params, 'id' => $this->id);
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param array $params
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Returns the
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->asArray());
    }

    /**
     * @param string $input
     *
     * @return Request
     */
    public static function fromString($input)
    {
        $request = json_decode($input);
        return new Request($request->method, $request->params, $request->id);
    }
}