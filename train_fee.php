<?php
$fee_info_txt = "행신-서울	8,400	13,200
행신-광명	8,400	13,200
행신-천안아산	15,600	21,800
행신-오송	20,100	28,100
행신-대전	25,200	35,300
행신-김천구미	36,400	51,000
행신-동대구	44,900	62,900
행신-신경주	50,600	70,800
행신-울산	54,800	76,700
행신-부산	61,100	85,500
서울-광명	8,400	13,200
서울-천안아산	14,100	19,700
서울-오송	18,500	25,900
서울-대전	23,700	33,200
서울-김천구미	35,100	49,100
서울-동대구	43,500	60,900
서울-신경주	49,300	69,000
서울-울산	53,500	74,900
서울-부산	59,800	83,700
광명-천안아산	11,600	16,400
광명-오송	16,100	22,500
광명-대전	21,200	29,700
광명-김천구미	32,900	46,100
광명-동대구	41,300	57,800
광명-신경주	47,100	65,900
광명-울산	51,300	71,800
광명-부산	57,700	80,800
천안아산-오송	8,400	13,200
천안아산-대전	9,600	14,400
천안아산-김천구미	21,500	30,100
천안아산-동대구	29,300	41,000
천안아산-신경주	34,900	48,900
천안아산-울산	40,200	56,300
천안아산-부산	46,500	65,100
오송-대전	8,400	13,200
오송-김천구미	17,000	23,800
오송-동대구	24,800	34,700
오송-신경주	30,700	43,000
오송-울산	34,800	48,700
오송-부산	42,200	59,100
대전-김천구미	11,900	16,700
대전-동대구	19,700	27,600
대전-신경주	25,800	36,100
대전-울산	30,100	42,100
대전-부산	36,200	50,700
김천구미-동대구	8,400	13,200
김천구미-신경주	13,800	19,300
김천구미-울산	18,200	25,500
김천구미-부산	24,900	34,900
동대구-신경주	8,400	13,200
동대구-울산	10,500	15,300
동대구-부산	17,100	23,900
신경주-울산	8,400	13,200
신경주-부산	11,000	15,800
울산-부산	8,400	13,200";

$fee_normal = array(); //일반실요금 배열
$fee_special = array();//특실요금 배열
$departure = array();//출발역 배열
$arrival = array();//도착역 배열

//역, 요금 정보 텍스트를 배열로 저장
$fee_info = explode("\r\n", $fee_info_txt);
// print_r($fee_info);

$fee_info_cnt = count($fee_info);
for($i=0;$i<$fee_info_cnt;$i++) {
	// 탭으로 구분하여 값 분리
	$tmp = explode("\t", $fee_info[$i]);
	// 일반실 요금 저장
	$fee_normal[$tmp[0]] = str_replace(",","", $tmp[1]);
	// 특실 요금 저장
	$fee_special[$tmp[0]] = str_replace(",","", $tmp[2]);
	// 역 정보 저장, - 으로 구분하여 값 분리
	$tmp2 = explode("-", $tmp[0]);
	$departure[] = $tmp2[0];
	$arrival[] = $tmp2[1];
}

function sel_station($name, $arr) {
	$arr = array_unique($arr);
	sort($arr);
	$cnt = count($arr);
	$str = "<select name='$name' required>\n<option value=''>역 선택</option>\n";
	foreach ($arr as &$value) {
		$str .= "<option value='$value'>$value</option>\n";
	}
	$str .= "</select>";
	return $str;
}

?>
<style>
th, td {height:40px;}
</style>
<h2>Train Ticketing System Ver 0.1</h2>
<form method="post">
<input type="hidden" name="mode" value="send">
<table border="0">
<tr>
<th align="left">Name</th><td><input type="text" name="name" size="20" required><td>
</tr>
<tr>
<th align="left">Phone</th><td><input type="text" name="phone" size="20" required><td>
</tr>
<tr>
<th align="left">Departure Station</th><td><?=sel_station("d", $departure)?><td>
</tr>
<tr>
<th align="left">Arrival Station</th><td><?=sel_station("a", $arrival)?><td>
</tr>
<tr>
<th align="left">Seat Type</th><td><input type="radio" name="seat" value="n" required>일반실 <input type="radio" name="seat" value="s" required>특실 <td>
</tr>
<tr>
<th align="left">Seats to buy</th><td><input type="text" name="cnt" size="20" maxlength="3" required><td>
</tr>
<tr>
<th colspan="2" align="left"><input type="submit" value="요금확인"> <input type="button" value="입력취소" onclick="location.href='train_fee.php'"></th>
</tr>
</table>
</form>

<?php
$mode = $_POST['mode'];

if($mode == "send") {
	extract($_POST);
	if($seat == "n") $fee = $fee_normal[$d."-".$a];
	else if($seat == "s") $fee = $fee_special[$d."-".$a];
	$result = $fee * $cnt;

	if($seat == "n") $seat = "일반실";
	else if($seat == "s") $seat = "특실";

	echo "<meta charset=\"euc-kr\">\n";
	echo "<font color='red'>Train fee($seat, $d - $a) is ".number_format($result)."</font>\n";
}
?>