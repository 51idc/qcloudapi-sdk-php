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
    }

    public function initProfile()
    {
        $this->profile = new \QcloudApi\Profile(
            getenv('SECRET_ID'),
            getenv('SECRET_KEY'),
            getenv('REGION') ?: $this->defaultRegion
        );
    }

}