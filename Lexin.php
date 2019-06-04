<?php
namespace clonelin\sms;

/**
 * 乐信短信发磅
 * Class Lexin
 * @package clonelin\sms
 */
class Lexin extends Base {

    protected static $target = 'http://cf.51welink.com/submitdata/Service.asmx/g_Submit';
    
    // 乐信短信
    public static function send($name,$password,$mobile,$template,$sign){

        //替换成自己的测试账号,参数顺序和wenservice对应
        $post_data = "sname={$name}&spwd={$password}&scorpid=&sprdid=1012818&sdst={$mobile}&smsg=".rawurlencode("{$template}【{$sign}】");
        $gets = self::smsPost($post_data, self::$target);
        return $gets;
    }

    // 短信POST
    private static function smsPost($data,$target){

        $url_info = parse_url($target);
        $httpHeader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpHeader .= "Host:" . $url_info['host'] . "\r\n";
        $httpHeader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpHeader .= "Content-Length:" . strlen($data) . "\r\n";
        $httpHeader .= "Connection:close\r\n\r\n";
        $httpHeader .= $data;

        $fd = fsockopen($url_info['host'], 80);
        fwrite($fd, $httpHeader);
        $gets = "";
        while(!feof($fd)) {
            $gets .= fread($fd, 128);
        }
        fclose($fd);
        if($gets != ''){
            $start = strpos($gets, '<?xml');
            if($start > 0) {
                $gets = substr($gets, $start);
            }
        }
        return $gets;
    }
}