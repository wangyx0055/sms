<?php
namespace clonelin\sms;

use clonelin\sms\enum\SendTypeEnum;

class SMS {

    // 发送短信
    public static function send($sendType,$params = []){
        if(!in_array(SendTypeEnum::ALIYUN_SMS,SendTypeEnum::LEXIN_SMS)){
            echo 'send type invalidate';
            return false;
        }
        // 校验参数
        $tmpAuthAccount = isset($params['auth_account']) ? $params['auth_account'] : '';
        $tmpAuthPassword = isset($params['auth_password']) ? $params['auth_password'] : '';
        $tmpSign = isset($params['sign']) ? $params['sign'] : '';
        $tmpSendAccount = isset($params['send_account']) ? $params['send_account'] : '';
        $tmpContent = isset($params['content']) ? $params['content'] : '';

        if(empty($tmpAuthAccount) || empty($tmpAuthPassword) || empty($tmpContent) || empty($tmpSign) || empty($tmpSendAccount)){
            echo "params invalidate";
            return false;
        }

        if($sendType == SendTypeEnum::ALIYUN_SMS) {
            $tmpTemplateID = isset($params['template_id']) ? $params['template_id'] : '';
            if(empty($tmpTemplateID)){
                echo "params invalidate";
                return false;
            }
            // 阿里云发送短信
            Aliyun::send($tmpAuthAccount,$tmpAuthPassword,$tmpSendAccount,$tmpContent,$tmpTemplateID,$tmpSign);
        }else{
            Lexin::send($tmpAuthAccount,$tmpAuthPassword,$tmpSendAccount,$tmpContent,$tmpSign);
        }



        return true;
    }
}
 
