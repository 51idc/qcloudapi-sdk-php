<?php
/**
 * QcloudApi_Common_Request
 */

namespace QcloudApi\Common;

use QcloudApi\Http\HttpHelper;

class Request
{
    /**
     * $_version
     * @var string
     */
    protected static $_version = 'SDK_PHP_1.1';

    private $domainParameters = array();


    /**
     * generateUrl
     * 生成请求的URL
     * @param $paramArray
     * @param $requestMethod
     * @param $requestHost
     * @param $requestPath
     * @return string
     */
    public static function generateUrl($paramArray, $requestMethod, $requestHost, $requestPath)
    {
        if (!isset($paramArray['Nonce'])) {
            $paramArray['Nonce'] = rand(1, 65535);
        }

        if (!isset($paramArray['Timestamp'])) {
            $paramArray['Timestamp'] = time();
        }

        $signMethod = 'HmacSHA1';
        if (isset($paramArray['SignatureMethod']) && $paramArray['SignatureMethod'] == "HmacSHA256") {
            $signMethod = 'HmacSHA256';
        }

        $paramArray['RequestClient'] = self::$_version;
        $plainText = Sign::makeSignPlainText($paramArray,
            $requestMethod, $requestHost, $requestPath);

        $paramArray['Signature'] = Sign::sign($plainText, $paramArray['SecretKey'], $signMethod);

        $url = 'https://' . $requestHost . $requestPath;
        if ($requestMethod == 'GET') {
            $url .= '?' . http_build_query($paramArray);
        }

        return $url;
    }

    /**
     * send
     * 发起请求
     * @param  array $paramArray 请求参数
     * @param  string $requestMethod 请求方式，GET/POST
     * @param  string $requestHost 接口域名
     * @param  string $requestPath url路径
     * @param bool $autoRetry
     * @param int $maxRetryNumber
     * @return \QcloudApi\Http\HttpResponse
     */
    public static function send(
        $paramArray,
        $requestMethod,
        $requestHost,
        $requestPath,
        $autoRetry = true,
        $maxRetryNumber = 3
    ) {
        if (!isset($paramArray['Nonce'])) {
            $paramArray['Nonce'] = rand(1, 65535);
        }

        if (!isset($paramArray['Timestamp'])) {
            $paramArray['Timestamp'] = time();
        }

        $signMethod = 'HmacSHA1';
        if (isset($paramArray['SignatureMethod']) && $paramArray['SignatureMethod'] == "HmacSHA256") {
            $signMethod = 'HmacSHA256';
        }

        $secretKey = $paramArray['SecretKey'];
        unset($paramArray['SecretKey']);

        $paramArray['RequestClient'] = self::$_version;
        $plainText = Sign::makeSignPlainText($paramArray, $requestMethod, $requestHost, $requestPath);

        $paramArray['Signature'] = Sign::sign($plainText, $secretKey, $signMethod);

        $selfObj = (new self);
        $url = 'https://' . $requestHost . $requestPath;
        $url = $selfObj->composeUrl($url, $requestMethod, $paramArray);
        if (count($selfObj->getDomainParameter())>0) {
            $httpResponse = HttpHelper::curl($url, $requestMethod, $selfObj->getDomainParameter());
        } else {
            $httpResponse = HttpHelper::curl($url, $requestMethod, $paramArray);
        }

        $retryTimes = 1;
        while (500 <= $httpResponse->getStatus() && $autoRetry && $retryTimes < $maxRetryNumber) {
            $url = 'https://' . $requestHost . $requestPath;
            $httpResponse = HttpHelper::curl($url, $requestMethod, $paramArray);
            $retryTimes++;
        }

        return $httpResponse;
    }

    /**
     * 处理URL
     * @param $requestUrl
     * @param $requestMethod
     * @param $paramArray
     * @return bool|string
     */
    public function composeUrl($requestUrl, $requestMethod, $paramArray)
    {
        if ($requestMethod == "POST") {
            foreach ($paramArray as $apiParamKey => $apiParamValue) {
                $this->putDomainParameters($apiParamKey, $apiParamValue);
            }
            return $requestUrl;
        } else {
            $requestUrl = $requestUrl . "?";
            foreach ($paramArray as $apiParamKey => $apiParamValue) {
                $requestUrl .= "$apiParamKey=" . urlencode($apiParamValue) . "&";
            }
            return substr($requestUrl, 0, -1);
        }
    }

    public function getDomainParameter()
    {
        return $this->domainParameters;
    }

    public function putDomainParameters($name, $value)
    {
        $this->domainParameters[$name] = $value;
    }
}

