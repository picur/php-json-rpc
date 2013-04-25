<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 15:58
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\Rpc\JSON;

abstract class Response {

    protected $responseObject = array('jsonrpc' => '2.0');

    function __construct($id, $content)
    {
        $this->responseObject['id'] = $id;
        $this->setContent($content);
    }

    /**
     * @return array
     */
    public function asArray() {
        return $this->responseObject;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return json_encode($this->responseObject);
    }

    /**
     * Sets the Response Content
     *
     * @param $content
     *
     * @return mixed
     */
    abstract function setContent($content);

}