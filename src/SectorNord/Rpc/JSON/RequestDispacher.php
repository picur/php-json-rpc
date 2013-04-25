<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 15:55
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\Rpc\JSON;

class RequestDispacher
{

    /** @var Request */
    protected $requestObject;

    /** @var mixed */
    protected $objectToDispatch;

    function __construct(Request $requestObject, $objectToDispatch)
    {
        $this->requestObject = $requestObject;
        $this->objectToDispatch = $objectToDispatch;
    }

    public function getResponse()
    {
        try {
            return new SuccesfullResponse($this->requestObject->getId(), $this->dispatchMethod(
                $this->requestObject->getMethod(),
                $this->requestObject->getParams()
            ));
        } catch (\Exception $e) {
            return new ErrorResponse($this->requestObject->getId(), array(
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ));
        }

    }

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     * @throws \Exception
     */
    protected function dispatchMethod($method, $args)
    {
        if (!method_exists($this->objectToDispatch, $method)) {
            throw new \Exception("Method does not exist", 404);
        }
        return call_user_func_array(array($this->objectToDispatch, $method), $args);
    }

}