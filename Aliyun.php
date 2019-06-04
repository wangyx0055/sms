<?php
namespace clonelin\sms;

/**
 * 阿里云短信发送
 * Class Aliyun
 * @package clonelin\sms
 */
class Aliyun extends Base{

    public static function send($name,$password,$mobile,$template,$templateID,$sign){
        return true;
    }
}