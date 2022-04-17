<?php

$arr = array();
for($i=1;$i<=45;$i++) {
	$arr[] = $i;
}

function lotto_chu($arr) {
	$chu = array();
	for($i=1;$i<=6;$i++) {
		shuffle($arr);
		$p = array_pop($arr);
		$chu[] = $p;
	}
	return $chu;
}

$chu = array();
for($i=0;$i<10;$i++) {
	$chu[] = lotto_chu($arr);
}

$chu_all = array_merge($chu[0], $chu[1], $chu[2], $chu[3], $chu[4], $chu[5], $chu[6], $chu[7], $chu[8], $chu[9]);
$chu_cnt = array_count_values($chu_all);
arsort($chu_cnt);

print "[lotto number]\n";
$i=1;
foreach($chu as $a) {
	print("$i : ".implode(",", $a))."\n";
	$i++;
}

print_r($chu_cnt);

?>