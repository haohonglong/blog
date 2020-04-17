<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 29/03/2018
 * Time: 1:44 PM
 */

namespace common\helper;

use yii;

class Help
{
    static public function mail($to='',$subject='',$message='',$headers)
    {
        $from = $headers['From'];
        $headers_def = [
            'From' => '',
            'Reply-To' => '',
            'Content-type' => 'text/html; charset=UTF-8',
            'X-Mailer' => 'PHP/' . phpversion()
        ];
        $headers = array_merge($headers_def,$headers);
        $headers = implode("\r\n", array_map(
            function ($v, $k) {return sprintf("%s: %s", $k, $v);},
            $headers,
            array_keys($headers)
        ));
        echo $headers;
        echo '<br/>';
        $headers2 = 'From: '.$from . "\r\n" .
            'Reply-To: '.$from . "\r\n" .
//            'Content-type: text/html; charset=UTF-8' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();





        echo '<br/>';
        echo $headers2;
        echo '<br/>';
//        exit;
        $a = mail($to, $subject, $message,$headers2);


        if($a){
            echo 'successfully';
        }else{
            echo 'fail';
        }
    }
    static public function ip2long()
    {
        return ip2long(Yii::$app->getRequest()->getUserIP());
    }

    static public function socket($ip='192.168.1.9',$port=1234)
    {
        $host=$ip;//主机地址
//设置超时时间
        set_time_limit(0);
//创建一个Socket
        $socket=socket_create(AF_INET,SOCK_STREAM,0) or die("Couldnotcreatesocket\n");//绑定Socket到端口
        $result=socket_bind($socket,$host,$port) or die("Couldnotbindtosocket\n");//开始监听链接
        $result=socket_listen($socket,3) or die("Couldnotsetupsocketlistener\n");//acceptincomingconnections
        //另一个Socket来处理通信
        $spawn=socket_accept($socket) or die("Couldnotacceptincomingconnection\n");//获得客户端的输入
        $input=socket_read($spawn,1024) or die("Couldnotreadinput\n");//清空输入字符串
        $input=trim($input);//处理客户端输入并返回结果
        $output=strrev($input)."\n";
        socket_write($spawn,$output,strlen($output)) or die("Couldnotwriteoutput\n");//关闭
        socket_close($spawn);
        socket_close($socket);
    }
    static public function video($file)
    {
        //First, see if the file exists
//        if (!is_file($file)) { die("<b>404 File not found!</b>"); }
        header( 'Expires: Mon, 1 Apr 1974 05:00:00 GMT' );
        header( 'Pragma: no-cache' );
        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
        header( 'Content-Description: File Download' );
        header( 'Content-Type: application/octet-stream' );
        header( 'Content-Length: '.filesize( $file ) );
        header( 'Content-Disposition: attachment; filename="'.basename( $file ).'"' );
        header( 'Content-Transfer-Encoding: binary' );
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
    static public function catche($url='')
    {

        $curl=curl_init();
//设置URL和相应的选项
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //将curl_exec()获取的信息以字符串返回，而不是直接输出。
//执行curl操作
        $data=curl_exec($curl);
        var_dump($data);
        exit;

    }

    /**
     * @author: lhh
     * 创建日期：2020-04-09
     * 修改日期：2020-04-09
     * 名称： generateActiveCode
     * 功能：生产邮箱激活码
     * 说明：
     * 注意：
     * @return string
     */
    static public function generateActiveCode()
    {
        return md5(uniqid(rand(),true));
    }

}