<?php
date_default_timezone_set('Asia/Dhaka');
$db=new PDO('mysql:host=localhost;dbname=testsql;charset=utf8','root','');
function randomNumber($range)
{
	$number = '';
	for ($i=0; $i < $range ; $i++) { 
		$number .= rand(0,9);
	}
	return (int) $number;
}
for ($j=0; $j < 100000; $j++) { 
	for ($i=0; $i < 100000; $i++) 
	{ 
		$q[] = "('".randomNumber(10)."','".randomNumber(5)."','".randomNumber(3)."')";
	}
	$q = implode(',', $q);
	$query = $db -> prepare("INSERT INTO test (data1, data2, data3) VALUES $q");
	$query -> execute();
	echo $j*$query->rowCount()." New Data Inserted\n";
	$q = '';
}
	
?>