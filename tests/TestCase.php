<?php
/**
 * qcloudapi-sdk-php
 * Author: Wudi <wudi@anchnet.com>
 * Datetime: 01/11/2017
 */

class TestCase extends PHPUnit_Framework_TestCase
{

    public $profile;

    public $defaultRegion = 'gz';

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->initProfile();

        var_dump($this->profile);
    }

    public function initProfile()
    {
        $secretId = isset($_ENV['SECRET_ID']) ? $_ENV['SECRET_ID'] : null;
        $secretKey = isset($_ENV['SECRET_KEY']) ? $_ENV['SECRET_KEY'] : null;
        $this->profile = new \QcloudApi\Profile($secretId, $secretKey, $this->defaultRegion);
    }

}