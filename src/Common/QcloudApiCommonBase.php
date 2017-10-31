<?php
/**
 * QcloudApi_Common_Base
 */

namespace QcloudApi\Common;

abstract class QcloudApiCommonBase
{
    /**
     * $_error
     * 错误号
     */
    protected $_error = 0;

    /**
     * setError
     * 设置错误信息
     *
     * @param  int $code 错误号
     * @param  string $message 错误信息
     * @param  string $ext 扩展信息
     * @return object
     */
    public function setError($code, $message, $ext = '')
    {
        $this->_error = new \QcloudApi\Common\QcloudApiCommonError($code, $message, $ext);
        return $this->_error;
    }

    /**
     * getError
     * 获取错误信息
     *
     * @return object
     */
    public function getError()
    {
        return $this->_error;
    }
}