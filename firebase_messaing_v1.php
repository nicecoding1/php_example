<?php
// 출처: https://blog.naver.com/whdals0/222683916484
/*
curl -sS https://getcomposer.org/installer | php
php composer.phar require google/auth
php composer.phar require google/apiclient:^2.12.1
*/

$url = 'https://fcm.googleapis.com/v1/projects/fcmsample-b5d93/messages:send';
require_once ('./vendor/autoload.php');
putenv('GOOGLE_APPLICATION_CREDENTIALS=./fcm_auth.json');
$scope = 'https://www.googleapis.com/auth/firebase.messaging';
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->setScopes($scope);
$auth_key = $client->fetchAccessTokenWithAssertion();
echo $auth_key['access_token'];

$ch = curl_init();
$headers = array
(
    'Authorization: Bearer ' . $auth_key['access_token'],
    'Content-Type: application/json'
);

curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 

$title = "제목입니다.";
$message = "내용입니다.";

$notification_opt = array (
    'title'         => $title,
    'body'          => $message,
    'image' => 'http://sowonbyul.com/original/totalAdmin/images/Icon-512.png'
);

$datas = array (
    'test1'     => '테스트 데이터1',
    'test2'     => '테스트 데이터2',
    'test3'     => '테스트 데이터3'
);

$android_opt = array (
    'notification' => array(
        'default_sound'         => true
    )
);

$message = array
(
    'token' => 'cFDXq8L7SMaU-mKlh3Yeev:APA91bGjmdOrtwcB1OR1I1hP0o3LXPChp6AiXKPQ7N9X5PQfNV5Uc7FS0m4y7N7Zm6Sq18JilurTlVQjN33PgmkqCRzlDaGxd18kNJrAKEsFPZzl7C_oqIG8ycfcYi0jQ8aOhx9kFIS-',
    'notification' => $notification_opt,
    'android' => $android_opt
);

$last_msg = array (
    "message" => $message
);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($last_msg)); 
$result = curl_exec($ch);

if($result === FALSE){
    // die('FCM Send Error: ' . curl_error($ch));
    printf("cUrl error (#%d): %s<br>\n",
    curl_errno($ch),
    htmlspecialchars(curl_error($ch)));
}

echo $result;

/*
ubuntu@fcm:~/test$ php send_fcm.php
ya29.c.b0Aaekm1IL7-3qkbvuCkziVcMsBeWFICLEaXJrX5qk_up9xwjlpxYv1_YcIvvBst-zHTTP/2 200
content-type: application/json; charset=UTF-8
vary: X-Origin
vary: Referer
vary: Origin,Accept-Encoding
date: Fri, 22 Sep 2023 16:06:37 GMT
server: scaffolding on HTTPServer2
cache-control: private
x-xss-protection: 0
x-frame-options: SAMEORIGIN
x-content-type-options: nosniff
alt-svc: h3=":443"; ma=2592000,h3-29=":443"; ma=2592000
accept-ranges: none

{
    "name": "projects/test-free/messages/0:1695398797178485%bf5671a5b"
}
*/
?>
