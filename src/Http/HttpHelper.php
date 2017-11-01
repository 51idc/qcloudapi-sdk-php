<?php

namespace QcloudApi\Http;
use QcloudApi\Exception\ClientException;

class HttpHelper
{
    /**
     * $_timeOut
     * 设置连接主机的超时时间
     * @var int 数量级：秒
     * */
    protected static $_timeOut = 10;
    protected static $_connectTimeout = 30;//30 second

    public static function curl($url, $requestMethod = "GET",$paramArray = null, $headers = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $requestMethod);
        if (ENABLE_HTTP_PROXY) {
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_PROXY, HTTP_PROXY_IP);
            curl_setopt($ch, CURLOPT_PROXYPORT, HTTP_PROXY_PORT);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($paramArray) ? self::getPostHttpBody($paramArray) : $paramArray);

        if(self::$_timeOut){
            curl_setopt($ch, CURLOPT_TIMEOUT, self::$_timeOut);
        }
        if (self::$_connectTimeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, self::$_connectTimeout);
        }

        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (is_array($headers) && 0 < count($headers)) {
            $httpHeaders =self::getHttpHearders($headers);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeaders);
        }

        $httpResponse = new HttpResponse();
        $httpResponse->setBody(curl_exec($ch));
        $httpResponse->setStatus(curl_getinfo($ch, CURLINFO_HTTP_CODE));
        if (curl_errno($ch)) {
            throw new ClientException("Server unreachable: Errno: " . curl_errno($ch) . " " . curl_error($ch), "SDK.ServerUnreachable");
        }
        curl_close($ch);

        return $httpResponse;
    }
    public static function getPostHttpBody($postFildes)
    {
        $content = "";
        foreach ($postFildes as $apiParamKey => $apiParamValue) {
            $content .= "$apiParamKey=" . urlencode($apiParamValue) . "&";
        }
        return substr($content, 0, -1);
    }
    public static function getHttpHearders($headers)
    {
        $httpHeader = array();
        foreach ($headers as $key => $value) {
            array_push($httpHeader, $key.":".$value);
        }
        return $httpHeader;
    }
}
