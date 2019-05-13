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

function choose_course2019()
{
    $url = 'http://hbs.zgzjzj.com/u/plancoursechoseing';
    $post_data = 'plan=%E6%B2%B3%E5%8C%97%E7%9C%812019%E5%B9%B4%E5%BA%A6%E4%B8%93%E4%B8%9A%E6%8A%80%E6%9C%AF%E4%BA%BA%E5%91%98%E5%85%AC%E9%9C%80%E7%A7%91%E7%9B%AE%E5%9F%B9%E8%AE%AD&planid=340&coursemessage=%E4%B9%A0%E8%BF%91%E5%B9%B3%E6%96%B0%E6%97%B6%E4%BB%A3%E4%B8%AD%E5%9B%BD%E7%89%B9%E8%89%B2%E7%A4%BE%E4%BC%9A%E4%B8%BB%E4%B9%89%E6%80%9D%E6%83%B3%E8%A7%A3%E8%AF%BB%3A%3A650%3A%3A10%3A%3A0%2C%E5%BC%98%E6%89%AC%E5%B7%A5%E5%8C%A0%E7%B2%BE%E7%A5%9E+%E8%BF%88%E5%90%91%E5%88%B6%E9%80%A0%E5%BC%BA%E5%9B%BD%3A%3A682%3A%3A10%3A%3A0%2C&coursemessage_num=20&coursemessage_1=%E7%AA%81%E5%8F%91%E4%BA%8B%E4%BB%B6%E5%85%B8%E5%9E%8B%E6%A1%88%E4%BE%8B%E5%89%96%E6%9E%90%3A%3A640%3A%3A10%3A%3A1%2C&coursemessage_1num=10';

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

function apply()
{
    $url = 'http://hbs.zgzjzj.com/u/plans/Apply?studytype=PLAN&studyid=340';
    //$post_data = 'plan=%E6%B2%B3%E5%8C%97%E7%9C%812019%E5%B9%B4%E5%BA%A6%E4%B8%93%E4%B8%9A%E6%8A%80%E6%9C%AF%E4%BA%BA%E5%91%98%E5%85%AC%E9%9C%80%E7%A7%91%E7%9B%AE%E5%9F%B9%E8%AE%AD&planid=340&coursemessage=%E4%B9%A0%E8%BF%91%E5%B9%B3%E6%96%B0%E6%97%B6%E4%BB%A3%E4%B8%AD%E5%9B%BD%E7%89%B9%E8%89%B2%E7%A4%BE%E4%BC%9A%E4%B8%BB%E4%B9%89%E6%80%9D%E6%83%B3%E8%A7%A3%E8%AF%BB%3A%3A650%3A%3A10%3A%3A0%2C%E5%BC%98%E6%89%AC%E5%B7%A5%E5%8C%A0%E7%B2%BE%E7%A5%9E+%E8%BF%88%E5%90%91%E5%88%B6%E9%80%A0%E5%BC%BA%E5%9B%BD%3A%3A682%3A%3A10%3A%3A0%2C&coursemessage_num=20&coursemessage_1=%E7%AA%81%E5%8F%91%E4%BA%8B%E4%BB%B6%E5%85%B8%E5%9E%8B%E6%A1%88%E4%BE%8B%E5%89%96%E6%9E%90%3A%3A640%3A%3A10%3A%3A1%2C&coursemessage_1num=10';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_POST,true);
    //curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__).'/cookie.txt'); //存储cookies
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); //存储cookies
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
