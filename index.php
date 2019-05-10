<?php

require_once 'function.php';
require_once 'daan.php';


if(empty($argv[1])){
    exit('请输入用户名');
}
if(empty($argv[2])){
    exit('请输入密码');
}

$user = $argv[1];
$pass = $argv[2];

$couserray = [
      340 => [
          650 => [2077,2078,2079,2080,2081,2082,2083,2084],
          //683 => [2392,2393,2394,2395,2396,2397,2398,2399,2400],
          682 => [2381,2382,2383,2384,2385,2386,2387,2388],
          640 => [1999],
          //643 => [2023],
      ],
//    220 =>[
//        26 => [342,343,344,345,346,347,348,349,350],
//        599 => [1510,1511,1512,1513,1514,1515,1516,1517],
//        //596 => [1484,1485,1486,1487,1488],
//        //601 => [1531,1532,1533,1534,1535,1536,1537],
//        493 => [1010],
//        563 => [1251],
//        559 => [1220],
//        //564 => [1259],
//        //571 => [1304],
//        //566 => [1273],
//        //571 => [1304],
//
//    ],
//    221 => [
//        5 => [33,34,35,36,37,38,39,40,41],
//        600 => [1520,1521,1522,1523,1524,1525,1526],
//        259 => [769],
//        547 => [1134],
//        548 => [1144],
//    ],
//    167 => [
//        //14 => [205,206,207,215,216,217,218,219,220],
//        35 => [357,358,359,360,361,362,363],
//        34 => [366,367,368,369,370,371,372,373],
//        12 => [187],
//        18 => [294],
//        27 => [227],
//    ]
];




$loginRes = login($user,$pass);
if($loginRes['code'] == 0){
    echo '登录成功！';
    $userID = $loginRes['data']['userId'];
}else{
    echo $loginRes['message'];
    die;
}

//$userID = 1222233;
foreach($couserray as $plan=>$course){
    foreach ($course as $c=>$video){
        foreach($video as $v){
            do{
                $uuidRes = get_uuid($v,$plan,$c,$userID,$v);
                //var_dump($uuidRes);die;
            }while(strlen($uuidRes)>500);
            //var_dump($uuidRes);die;
            $play_uuid = substr($uuidRes,strpos($uuidRes,'play.html?uuids=')+16,8);
            echo $play_uuid;
            echo "\n";
            for($i=0;$i<3;$i++)
            {
                var_dump(send_wth($play_uuid));
            }
            var_dump(send_time($play_uuid));
            var_dump(send_finish($play_uuid));
            sleep(3);
        }
    }
}

echo "刷课时已经完成，开始进行考试流程！\n";
foreach ($answer as $k=>$a){
    post_exam($a);
    echo "考完第".($k+1)."门！\n";
}










