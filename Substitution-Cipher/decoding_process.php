<?php 

$key=$_POST['key'];
$code=$_POST['code'];

//echo $key;
$arr = str_split($key);
$dep_arr=array_unique($arr);
$key=implode('', $dep_arr);
$key=strtolower($key);
//print_r(count($dep_arr));
$row=0;
$col=0;
$multi_array = array(//25
    array(),
    array(),
);
$array=array(//25-count($dep_arr)
	array()
);
for($i=0; $i<26; $i++){
	for($j=0; $j<count($dep_arr); $j++){
		
		if(chr(97+$i)!=$key[$j]){
			print_r(chr(97+$i));
			print_r($key[$j]."   ");
			$array[$i]=chr(97+$i);
			break;
		}else{

		}
	}
	if(chr(97+$i)>='z'){
		break;
	}
}

print_r($array);
// echo 'dd';
for($i=0; $i<25; $i++){
	if($i<count($dep_arr)){
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
print_r($multi_array);


?>