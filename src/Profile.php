<?php
/**
 * qcloudapi-sdk-php
 * Author: Wudi <wudi@anchnet.com>
 * Datetime: 30/10/2017
 */

namespace QcloudApi;


class Profile
{

    protected $secretId;
    protected $secretKey;
    protected $region;

    /**
     * Profile constructor.
     * @param $secretId
     * @param $secretKey
     * @param $region
     */
    public function __construct($secretId, $secretKey, $region)
    {
        $this->secretId = $secretId;
        $this->secretKey = $secretKey;
        $this->region = $region;
    }


    /**
     * @return mixed
     */
    public function getSecretId()
    {
        return $this->secretId;
    }

    /**
     * @param mixed $secretId
     */
    public function setSecretId($secretId)
    {
        $this->secretId = $secretId;
    }

    /**
     * @return mixed
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param mixed $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }


}