<?php
$fee_info_txt = "���-����	8,400	13,200
���-����	8,400	13,200
���-õ�Ⱦƻ�	15,600	21,800
���-����	20,100	28,100
���-����	25,200	35,300
���-��õ����	36,400	51,000
���-���뱸	44,900	62,900
���-�Ű���	50,600	70,800
���-���	54,800	76,700
���-�λ�	61,100	85,500
����-����	8,400	13,200
����-õ�Ⱦƻ�	14,100	19,700
����-����	18,500	25,900
����-����	23,700	33,200
����-��õ����	35,100	49,100
����-���뱸	43,500	60,900
����-�Ű���	49,300	69,000
����-���	53,500	74,900
����-�λ�	59,800	83,700
����-õ�Ⱦƻ�	11,600	16,400
����-����	16,100	22,500
����-����	21,200	29,700
����-��õ����	32,900	46,100
����-���뱸	41,300	57,800
����-�Ű���	47,100	65,900
����-���	51,300	71,800
����-�λ�	57,700	80,800
õ�Ⱦƻ�-����	8,400	13,200
õ�Ⱦƻ�-����	9,600	14,400
õ�Ⱦƻ�-��õ����	21,500	30,100
õ�Ⱦƻ�-���뱸	29,300	41,000
õ�Ⱦƻ�-�Ű���	34,900	48,900
õ�Ⱦƻ�-���	40,200	56,300
õ�Ⱦƻ�-�λ�	46,500	65,100
����-����	8,400	13,200
����-��õ����	17,000	23,800
����-���뱸	24,800	34,700
����-�Ű���	30,700	43,000
����-���	34,800	48,700
����-�λ�	42,200	59,100
����-��õ����	11,900	16,700
����-���뱸	19,700	27,600
����-�Ű���	25,800	36,100
����-���	30,100	42,100
����-�λ�	36,200	50,700
��õ����-���뱸	8,400	13,200
��õ����-�Ű���	13,800	19,300
��õ����-���	18,200	25,500
��õ����-�λ�	24,900	34,900
���뱸-�Ű���	8,400	13,200
���뱸-���	10,500	15,300
���뱸-�λ�	17,100	23,900
�Ű���-���	8,400	13,200
�Ű���-�λ�	11,000	15,800
���-�λ�	8,400	13,200";

$fee_normal = array(); //�Ϲݽǿ�� �迭
$fee_special = array();//Ư�ǿ�� �迭
$departure = array();//��߿� �迭
$arrival = array();//������ �迭

//��, ��� ���� �ؽ�Ʈ�� �迭�� ����
$fee_info = explode("\r\n", $fee_info_txt);
// print_r($fee_info);

$fee_info_cnt = count($fee_info);
for($i=0;$i<$fee_info_cnt;$i++) {
	// ������ �����Ͽ� �� �и�
	$tmp = explode("\t", $fee_info[$i]);
	// �Ϲݽ� ��� ����
	$fee_normal[$tmp[0]] = str_replace(",","", $tmp[1]);
	// Ư�� ��� ����
	$fee_special[$tmp[0]] = str_replace(",","", $tmp[2]);
	// �� ���� ����, - ���� �����Ͽ� �� �и�
	$tmp2 = explode("-", $tmp[0]);
	$departure[] = $tmp2[0];
	$arrival[] = $tmp2[1];
}

function sel_station($name, $arr) {
	$arr = array_unique($arr);
	sort($arr);
	$cnt = count($arr);
	$str = "<select name='$name' required>\n<option value=''>�� ����</option>\n";
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
<th align="left">Seat Type</th><td><input type="radio" name="seat" value="n" required>�Ϲݽ� <input type="radio" name="seat" value="s" required>Ư�� <td>
</tr>
<tr>
<th align="left">Seats to buy</th><td><input type="text" name="cnt" size="20" maxlength="3" required><td>
</tr>
<tr>
<th colspan="2" align="left"><input type="submit" value="���Ȯ��"> <input type="button" value="�Է����" onclick="location.href='train_fee.php'"></th>
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

	if($seat == "n") $seat = "�Ϲݽ�";
	else if($seat == "s") $seat = "Ư��";

	echo "<meta charset=\"euc-kr\">\n";
	echo "<font color='red'>Train fee($seat, $d - $a) is ".number_format($result)."</font>\n";
}
?>