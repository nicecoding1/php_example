<?php
session_start();

/*
 * 카운터 예제
 * 테이블 생성 스크립트
 create table `counter`( 
   `hit_today` int NOT NULL DEFAULT '0' , 
   `hit_yesterday` int NOT NULL DEFAULT '0' , 
   `hit_month` int NOT NULL DEFAULT '0' , 
   `hit_total` int NOT NULL DEFAULT '0' , 
   `hit_date` date 
 ); 
 insert into counter set hit_today='0', hit_yesterday='0', hit_month='0', hit_total='0', hit_date=now();
 */

$today = date('Y-m-d');
$ym = date('Y-m');
$ip = $_SERVER['REMOTE_ADDR'];

$db_host = "localhost";
$db_user = "db_user";
$db_pass = "db_pass";
$db_name = "db_name";

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name) or die("DB connect fail !");
mysqli_query($conn, "set names utf8");

function dbquery($sql) {
	global $conn;
	$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	return $res;
}

function dbfetch($res) {
	$row = mysqli_fetch_array($res);
	return $row;
}

function dbqueryfetch($sql) {
	global $conn;
	$res = mysqli_query($conn, $sql) or die(mysqli_error($conn));
	$row = mysqli_fetch_array($res);
	return $row;
}

if($_REQUEST['mode'] == "setup") {
    $sql = "create table `counter`( 
        `hit_today` int NOT NULL DEFAULT '0' , 
        `hit_yesterday` int NOT NULL DEFAULT '0' , 
        `hit_month` int NOT NULL DEFAULT '0' , 
        `hit_total` int NOT NULL DEFAULT '0' , 
        `hit_date` date 
      ); ";
    dbquery($sql);
    $sql = "insert into counter set hit_today='0', hit_yesterday='0', hit_month='0', hit_total='0', hit_date=now()";
    dbquery($sql);
    exit;
}

$sql = "select * from counter";
$row = dbqueryfetch($sql);
if($row['hit_today'] == "") {
	$sql = "insert into counter set hit_today='0', hit_yesterday='0', hit_month='0', hit_total='0'";
	dbquery($sql);
}

if($_SESSION['mystory_visit_'.$ip.'_'.$today] != "Y") {
	//오늘
	if($row['hit_date'] != $today) {
		$sql = "update counter set hit_yesterday=hit_today ";
		dbquery($sql);

		$sql = "update counter set hit_today=0, hit_date='$today'";
		dbquery($sql);
	}

	//이달
	if(substr($row['hit_date'],0,7) != $ym) {
		$sql = "update counter set hit_month=0";
		dbquery($sql);
	}

	$sql = "update counter set hit_today=hit_today+1, hit_month=hit_month+1, hit_total=hit_total+1, hit_date=now()";
	dbquery($sql);

	//방문 세션 생성
	if($_SESSION['mystory_visit_'.$ip.'_'.$today] != "Y") $_SESSION['mystory_visit_'.$ip.'_'.$today] = "Y";
}

$sql = "select * from counter";
$counter = dbqueryfetch($sql);

?>

<div style="width:100%; text-align:center; margin-top:15px">
<small>
오늘 <?=number_format($counter['hit_today'])?><br>
어제 <?=number_format($counter['hit_yesterday'])?><br>
이달 <?=number_format($counter['hit_month'])?><br>
누적 <?=number_format($counter['hit_total'])?><br>
</small>
</div>