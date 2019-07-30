<?php

namespace Expand;

/**
 * 简单封装OpenSSL加密解密函数
 * Class DES
 * @package Expand
 */
class OpenSSL{

    /**
     * 加密方式 默认为 DES-ECB
     * @var string
     */
    public $method = 'DES-ECB';

    /**
     * 密钥key
     * @var string
     */
    public $key = '';

    /**
     * 选择OPENSSL_RAW_DATA，需要base64加密处理，否则显示的是乱码
     * 可选OPENSSL_RAW_DATA 或者 OPENSSL_ZERO_PADDING
     * @var string
     */
    public $option = 0;

    /**
     * 非 NULL 的初始化向量。
     * @var string
     */
    public $iv = '';

    /**
     * OpenSSL constructor.
     * @param $key 加密和解密的密钥
     * @param string $method 加密方法
     */
    public function __construct($key, $method = 'DES-ECB') {
        $this->key = $key;
        $this->method = $method;
        if(function_exists('openssl_cipher_iv_length') === false || function_exists('openssl_random_pseudo_bytes') === false ){
            return 'openssl加密扩展未部署';
        }
        $ivlen = openssl_cipher_iv_length($method);
        $this->iv = openssl_random_pseudo_bytes($ivlen);
    }

    /**
     * 对数据进行加密
     * @param $data 明文
     * @param int $display 声明OPENSSL_RAW_DATA将显示乱码，是否需要显示为base数据
     * @return string
     */
    public function encrypt($data, $display = 0){
        if(function_exists('openssl_encrypt') === false){
            return 'openssl加密扩展未部署';
        }

        $result = openssl_encrypt($data, $this->method, $this->key, $this->option, $this->iv);

        if($display == 1){
            return base64_encode($result);
        }else{
            return $result;
        }
    }

    /**
     * 对加密的数据还原为明文
     * @param $data 加密的数据
     * @param int $base 如果是OPENSSL_RAW_DATA数据处理过base则进行解包
     * @return string
     */
    public function decrypt($data, $base = 0){
        if(function_exists('openssl_decrypt') === false){
            return 'openssl加密扩展未部署';
        }
        $data = $base == 1 ? base64_decode($data) : $data;
        return openssl_decrypt($data, $this->method, $this->key, $this->option, $this->iv);
    }

}