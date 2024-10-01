<?php

function get_lat_long($address) {
    $apiUrl = "https://address.dawul.co.kr/input_pro.php";
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $apiUrl,
	CURLOPT_SSL_VERIFYPEER => 0,
	CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => 'refine_ty=8&protocol_='.urlencode($address),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
    ));
    

    $response = curl_exec($curl);
    curl_close($curl);
    $temp = explode("|", $response);
    $arr[0] = $temp[4];
    $arr[1] = $temp[3];

    //서울특별시 중구 한강대로 405  (봉래동2가, 경부고속철도서울민자역사)|서울특별시 중구 봉래동2가 122-11 |04509|126.969422|37.5562730
    /*
    서울특별시 중구 한강대로 405  (봉래동2가, 경부고속철도서울민자역사)
    서울특별시 중구 봉래동2가 122-11
    04509
    126.969422
    37.5562730
    */

    return $arr;
}

$address = "서울 중구 한강대로 405";
$result = get_lat_long($address);
print("주소: ".$address."\n\n");
print("위도: {$result[0]}, 경도: {$result[1]}");
?>
