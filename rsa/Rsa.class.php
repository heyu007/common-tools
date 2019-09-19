<?php
// +----------------------------------------------------------------------
// | [good good study , day day up ]
// +----------------------------------------------------------------------
// | describe: RSA Encryption Class
// +----------------------------------------------------------------------
// | version: 1.0
// +----------------------------------------------------------------------
// | time: 2019/9/18
// +----------------------------------------------------------------------
// | Author: heyu <18781085152@163.com>
// +----------------------------------------------------------------------

class Rsa{

    /**
     * 私钥key
     * @var string
     */
    private static $private_key = '-----BEGIN PRIVATE KEY-----
MIICdQIBADANBgkqhkiG9w0BAQEFAASCAl8wggJbAgEAAoGBAMgG4G8M4mEUpY+N
/nuxRnnoXlP6NCEQqcfLEDUeyA9MAVkD7UKqpfnA/xLoO7qpoU4q8045StZd85ib
5EAmKHr59Pog1J4dQkHNK0BCVruWS8Z11S4UHmFcPHQgCueDwJTDVi0cNb83SdYa
qS/3VjpQuZcPG2n0tHGpACSXIrvVAgMBAAECgYB9XzoKwMOfX6aJvNE1zB5FSKze
6+MCmoQf8xn8gYeZduUdWwW6FGWljh8SRbcyPyIYcXlAnU5X4FlPXN6KiqAxoDe6
ZLH1BgGy9KlafhBH6MT5YLu1b8cHZaEpir6ev8nLvspo81Eyig30dV3X/eEh6Owo
Q2RiStgOHsRpx9GKPQJBAO2+eerXF1Wy6y8w1sZMjf0Pzn52aUZEMQ0sZu4KCvTX
05qMcbgSnZf+6VN5vPsMg2Ar1inVvDsaGgwYlec887MCQQDXYva4QOknrks9uE5g
y0Ol1ItcDppahC7r0uzR07sreJi4nrTeJOCTQVYrNDoeUKI3nnrEeW0wbhgG4s4V
925XAkBiOMOd5mdZnKXVxVO2cYJn/tPNI5ay1RF+481SowuLxG9D9qo05lv9o+85
8Z3GCpFsdi/w8MDnmg0Q2kd0VZZJAkABmAzlXi2bipGp+kQyOS7d+k2xt7Xyt4m1
WxE/mEaJUtImg54pCrLSxCgEF9XaRZR9vuF/tLpXImlxG5qU1QjvAkATD+5SQCH4
9PbgPlTnhqWBTi5uhAmIs0fO4RuZnNB9/yB2a2FrXwYcvNUpiYOLzCrVboCmhIFu
0Rac9ETrhwA6
-----END PRIVATE KEY-----';

    /**
     * 公钥key
     * @var string
     */
    private static $public_key = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIBuBvDOJhFKWPjf57sUZ56F5T
+jQhEKnHyxA1HsgPTAFZA+1CqqX5wP8S6Du6qaFOKvNOOUrWXfOYm+RAJih6+fT6
INSeHUJBzStAQla7lkvGddUuFB5hXDx0IArng8CUw1YtHDW/N0nWGqkv91Y6ULmX
Dxtp9LRxqQAklyK71QIDAQAB
-----END PUBLIC KEY-----';

    private static $is_private_key;


    private static $is_public_key;

    /**
     * 初始化rsa
     * Rsa constructor.
     */
    public function __construct(){

        //检测私钥
        self::$is_private_key = openssl_pkey_get_private(self::$private_key);

        //检测公钥
        self::$is_public_key = openssl_pkey_get_public(self::$public_key);

        //判断公钥与私钥是否可用
        if(!self::$is_private_key || !self::$is_public_key) exit('密钥或者公钥不可用');

    }


    /**
     * 公钥解密
     * @param $encryptData
     * @return bool|string
     */
    private static function rsaDecrypt($encryptData){

        //进行RSA解密
        if(openssl_public_decrypt($encryptData,$decryptData,self::$is_public_key)){

            return $decryptData;
        }else{

            return false;
        }

    }

    /**
     * 私钥加密
     * @param $originalData
     * @return bool|string
     */
    private static function rsaEncrypt($originalData){

        //进行RSA加密
        if(openssl_private_encrypt($originalData,$encryptData,self::$is_private_key)){

            return $encryptData;
        }else{

            return false;
        }

    }


    /**
     * 加密
     * @param $param
     * @return string 返回base64 加密的数据
     */
    public function encrypt($param){

        //判断加密参数
        if(empty($param)) exit('加密数据不能为空');

        //获取rsa加密结果
        $encrypt_result = self::rsaEncrypt($param);

        //判断加密是否成功
        if($encrypt_result === false) exit('加密失败');

        return base64_encode($encrypt_result);

    }

    /**
     * 解密
     * @param $param
     * @return bool|string
     */
    public function decrypt($param){

        //判断加密参数
        if(empty($param)) exit('解密数据不能为空');

        //获取rsa解密结果
        $decrypt_result = self::rsaDecrypt(base64_decode($param));

        //判断解密是否成功
        if($decrypt_result === false) exit('解密失败');

        return $decrypt_result;

    }
}

//--------------------------- 实例 开始 ---------------------------
$one = new Rsa();

$pass = '123345abc';

$repeat_str = str_repeat('-',20);

print($repeat_str.'加密 start'.$repeat_str);

echo '<br>';

$jiami = $one->encrypt($pass);

print_r($jiami);

echo '<br>';

print($repeat_str.'加密 end'.$repeat_str);

echo '<br>';

print($repeat_str.'解密 start'.$repeat_str);

echo '<br>';

print_r($one->decrypt($jiami));

echo '<br>';

print($repeat_str.'解密 end'.$repeat_str);

//--------------------------- 实例 结束 ---------------------------