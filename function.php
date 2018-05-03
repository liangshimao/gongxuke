<?php

function login($username,$password)
{
    $params = [
        'username' => $username,
        'password' => $password,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://hbs.zgzjzj.com/sign_in.action?'.http_build_query($params));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //存储cookies
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result,true);

}

function get_uuid($id,$planid,$courseid,$userid,$videoid)
{
    $param = [
        'id'=>$id,
        'planid'=>$planid,
        'courseid'=>$courseid,
        'userid'=>$userid,
        'videoid'=>$videoid,
        'studytype'=>'',

    ];
    $url = 'http://hbs.zgzjzj.com/u/played?'.http_build_query($param);
    echo $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //存储cookies
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function send_wth($uuid)
{
    $url = 'http://hbs.zgzjzj.com/wt?callback=WTH';
    $post_data = [
        'command'=>'onPlay'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //存储cookies
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: text/javascript, application/javascript, application/ecmascript, application/x-ecmascript, */*; q=0.01',
        'Accept-Encoding: gzip, deflate',
        'Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2',
        'Connection: keep-alive',
        'Content-Length: 20',
        'Content-Type: application/json; charset=utf-8',
        'Host: hbs.zgzjzj.com',
        'Referer: http://hbs.zgzjzj.com/play.html?uuids='.$uuid,
        'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:59.0) Gecko/20100101 Firefox/59.0',
        'X-Requested-With: XMLHttpRequest'
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function send_time($uuid)
{

    $url= 'http://hbs.zgzjzj.com/finishextend?uuid='.$uuid.'&times=3600';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //存储cookies
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function send_finish($uuid)
{
    $url= 'http://hbs.zgzjzj.com/finish?callback=WTH';
    $post_data = [
        'command'=>'putTimes|'.$uuid.'|'.'3600'
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //存储cookies
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function post_exam($post_data)
{
    $url = 'http://hbs.zgzjzj.com/u/plansexamtosubmit?savetype=1';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST,true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //存储cookies
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function getJsonResult($string)
{
    $left = strpos($string,'(');
    $right = strrpos($string,')');
    $result = substr($string,$left+1,$right-$left-1);
    return json_decode($result,true);
}