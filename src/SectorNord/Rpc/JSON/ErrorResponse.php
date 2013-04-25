<?php
/**
 * Created by IntelliJ IDEA.
 * User: frankhildebrandt
 * Date: 24.04.13
 * Time: 15:59
 * To change this template use File | Settings | File Templates.
 */

namespace SectorNord\Rpc\JSON;


class ErrorResponse extends Response {
    /**
     * Sets the Response Content
     *
     * @param $content
     *
     * @return mixed
     */
    function setContent($content)
    {
        $this->responseObject['error'] = $content;
    }


}