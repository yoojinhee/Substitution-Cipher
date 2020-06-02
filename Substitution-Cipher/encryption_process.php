<?php 

$key=$_POST['key'];//assassinator
$code=$_POST['code'];

$arr = str_split($key);//assassinator 배열
$dep_arr=array_unique($arr);//asintor 배열
$key=implode('', $dep_arr);//asintor
$key=strtolower($key);//대문자 -> 소문자
$sort_key=$key;
$row=0;
$col=0;
$multi_array = array(//25
    array(),
    array(),
);
$array=array(//25-count($dep_arr)
	array()
);
$temp="";

for($i=0; $i<count($dep_arr)-1; $i++){
	for($j=$i+1; $j<count($dep_arr); $j++){
		if(ord($sort_key[$i])>ord($sort_key[$j])){
			$temp=$sort_key[$i];
			$sort_key[$i]=$sort_key[$j];
			$sort_key[$j]=$temp;
		}
	}
}
echo $sort_key[0];
for($i=0; $i<26-count($dep_arr); $i++){
	if(chr($i+97)==$sort_key[$i]){
	continue;
	}else{
		$array[$i]=$sort_key[$i];
	}
	
}
// for($i=0; $i<26; $i++){
// 	for($j=$i; $j<count($dep_arr); $j++){
		
// 		if(chr(97+$i)==$key[$j]){
// 			//print_r(chr(97+$i));
// 			//print_r($key[$j]."   ");
// 			//$array[$i]=chr(97+$i);
// 			break;
// 		}else{
// 			$array[$i]=chr(97+$i);
// 		}
// 	}
// 	if(chr(97+$i)>='z'){
// 		break;
// 	}
// }

print_r($array);
// echo 'dd';
for($i=0; $i<25; $i++){
	if($i<count($dep_arr)){//key의 글자수
		$multi_array[$row][$col]=$key[$i];
	}else{
		//암호키 제외한 문자 넣기
	}
	if($col==4){
		$row++;
		$col=0;
	}else{
		$col++;
	}
}
//print_r($multi_array);


?>