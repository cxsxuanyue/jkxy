<?php

namespace App\libraries;

use App\libraries\SecretClass;

/**
 * Class Base Service 基类
 *
 * @package App\Service
 * @author 左霄红
 * @date 20161102
 */
class Base
{
    /**
     * CURL 参数加密方法
     * @param $url 请求的URL
     * @param bool $params 参数
     * @param int $ispost post或者get
     * @param int $https
     * @return bool
     */
    public function scurl($url, $params = [], $key = null, $ispost = 1, $https = 0)
    {
        // 加密key
        $key = $key ? $key : config('api.key');

        // 将参数转为json字符串
        $string = json_encode($params);

        //加密参数
        $secrect = new SecretClass();
        $params = $secrect->authcode($string, 'ENCODE', $key);

        // 获取签名
        $time = time();
        $sign = $secrect->makeSign($time);

        $arr = [
            'param' => $params,
            'sign' => $sign,
            'time' => $time
        ];
        return self::curl($url, $arr, $ispost, $https);
    }


    /**
     * CURLf方法
     * @param $url 请求的URL
     * @param bool $params 参数
     * @param int $ispost post或者get
     * @param int $https
     * @return bool
     */
    public function curl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {

            if ($params) {
                if (is_array($params)){
                    $params =  http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);


        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);

        return $response;
    }
}
