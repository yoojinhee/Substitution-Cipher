<?php 
$key=$_POST['key'];//암호키
$code=$_POST['code'];//평문
$prevkey=$key;//바뀌기 이전 키
$prevcode=$code;//바뀌기 이전 키

$multi_array = array(//암호판
    array(),
    array(),
);

$array=array(//암호키 중복제거한 값
	array()
);

$xindex=array();//들어가는 x의 인덱스
$zchkindex=array();//평문 z의 인덱스 
$qzarr=array();//암호문 zq/qz 인덱스

$arr = str_split($key);//암호키를 배열로
$dep_arr=array_unique($arr);//암호키를 중복제거하여 배열로
$key=implode('', $dep_arr);//배열을 문자열로
$key=strtolower($key);//대문자 -> 소문자
$sort_key=$key;

$code=preg_replace("/\s+/", "", $code);//평문 공백제거
$change_code=$code;

//평문에 'z'있는지 체크하고 있다면 'q'로 바꿔줌
//평문에 zq나 qz를 포함하고 있다면 qzarr배열에 해당되는 암호를 넣어줌
$qzcnt=0;
for($i=0; $i<strlen($change_code); $i++){
	if($change_code[$i]=='z'&&$change_code[$i+1]=='q'){
		$qzarr[$qzcnt++]=$change_code[$i+1];
		$qzarr[$qzcnt++]=$change_code[$i];
	}else if($change_code[$i]=='q'&&$change_code[$i+1]=='z'){
		$qzarr[$qzcnt++]=$change_code[$i+1];
		$qzarr[$qzcnt++]=$change_code[$i];
	}
	if($change_code[$i]=='z'){
		$change_code[$i]='q';//z->q
		$zchkindex[$i]='z';
	}
}
//연속으로 나타나는 문자에 x를 넣어줌
for($i=0; $i<strlen($change_code); $i+=2){
	if(isset($change_code[$i+1])){
		if($change_code[$i]==$change_code[$i+1]){
			$change_code=substr_replace($change_code,'x',$i+1,0);
			$xindex[$i+1]='x';
		}
	}
}

//마지막 홀수 글자가 남을 경우 x를 붙여줌
if(strlen($change_code)%2==1){
	$change_code=$change_code.'x';
	$xindex[strlen($change_code)-1]='x';
}
$codestr='';
for($i=0; $i<strlen($change_code); $i+=2){
	$codestr=$codestr.$change_code[$i].$change_code[$i+1]." ";
}
// echo $codestr;
$change_code = str_split($change_code,2);//2글자로 나눠서 배열로 생성

//중복을 제거한 암호키를 알파벳 순서대로 나열
$temp="";
for($i=0; $i<count($dep_arr)-1; $i++){
	for($j=$i+1; $j<count($dep_arr); $j++){
		if(ord($sort_key[$i])>ord($sort_key[$j])){
			$temp=$sort_key[$i];
			$sort_key[$i]=$sort_key[$j];
			$sort_key[$j]=$temp;
		}
	}
}//asintor -> ainorst

//array에 중복된 값을 제거한 암호키를 제외한 나머지 알파벳 삽입
$temp=0;
$cnt=0;
for($i=0; $i<=count($dep_arr); $i++){
	for($j=$temp; $j<25; $j++){
		if($i<count($dep_arr)){
			if(chr($j+97)==$sort_key[$i]){
				$temp=$j+1;
				break;
			}else{
				$array[$cnt]=chr($j+97);
				$cnt++;
			}
		}else{
			$array[$cnt]=chr($j+97);
			$cnt++;
		}
	}
}

//중복된 값을 제거한 암호키와 나머지 알파벳을 순서대로 multi_array에 삽입하여 암호판을 만듬
$row=0;
$col=0;
$temp=0;
$list='';
for($i=0; $i<25; $i++){
	if($i<count($dep_arr)){//key의 글자수
		$multi_array[$row][$col]=$key[$i];
	}else{
		$multi_array[$row][$col]=$array[$i-count($dep_arr)];
	}
	if($col==4){
		$list=$list.
		'
		<tr>
			<td>'.$multi_array[$row][0].'</td>
			<td>'.$multi_array[$row][1].'</td>
			<td>'.$multi_array[$row][2].'</td>
			<td>'.$multi_array[$row][3].'</td>
			<td>'.$multi_array[$row][4].'</td>
		</tr>
		';
		$row++;
		$col=0;
	}else{
		$col++;
	}
}


$lockarr='';
$decarr='';
$lockarr=cryption($change_code,$multi_array,$lockarr,1,$qzarr);//암호문
$decarr=cryption(str_split($lockarr,2),$multi_array,$decarr,4,$qzarr);//복호문

//암호문의 'x' 대신 공백 삽입
for($i=0; $i<strlen($decarr); $i++){
	if(isset($xindex[$i])){
		if($xindex[$i]==$decarr[$i]){
			$decarr[$i]=' ';
		}
	}
}
$decarr=preg_replace("/\s+/", "", $decarr);//공백제거

//복호화에서 q를 z로 되돌림
for($i=0; $i<strlen($decarr); $i++){
	if(isset($zchkindex[$i])){
		if($zchkindex[$i]=='z'){
			//print_r($xindex[$i]);
			$decarr[$i]='z';
		}
	}
}

//암호문 띄어쓰기
$specing_lockarr='';
for($i=0; $i<strlen($lockarr); $i+=2){
	if(isset($lockarr[$i])){
		$specing_lockarr=$specing_lockarr.$lockarr[$i].$lockarr[$i+1]." ";
	}
}	

function cryption($change_code,$multi_array,$lockarr,$num,$qzarr){
	$x1=0;
	$x2=0;
	$y1=0;
	$y2=0;
	$qxbool=false;
	$qzbool=false;
	$qzcnt=0;

	for($i=0; $i<count($change_code); $i++){
		$codearr = str_split($change_code[$i]);
		
		if($codearr[0]=='q'&&$codearr[1]=='x'){
			$qxbool=true;
		}
		if($codearr[0]=='z'&&$codearr[1]=='q'||$codearr[0]=='q'&&$codearr[1]=='z'){
			$qzbool=true;
		}

		for($j=0; $j<count($multi_array); $j++){//쌍자암호의 각각 위치체크
			for($k=0; $k<count($multi_array[$j]); $k++){
				if($multi_array[$j][$k]==$codearr[0]){
					$x1=$j;
					$y1=$k;
				}
				if($multi_array[$j][$k]==$codearr[1]){
					$x2=$j;
					$y2=$k;
				}
			}
		}
		//'qx'가 존재할 경우 'qz'->'zq'로, 'zq'->'qz'로 암호화
		if($qxbool){
			$lockarr=$lockarr.$qzarr[$qzcnt++];
			$lockarr=$lockarr.$qzarr[$qzcnt++];
			$qxbool=false;
		}
		//'암호문에 'qz'나 'zq'가 존재할 경우 'qx'로 변환
		else if($qzbool){
			$lockarr=$lockarr.'q';
			$lockarr=$lockarr.'x';
			$qzbool=false;
		}
		else if($x1==$x2) //행이 같은경우
		{
			$lockarr=$lockarr.$multi_array[$x1][($y1+$num)%5];
			$lockarr=$lockarr.$multi_array[$x2][($y2+$num)%5];
		}
		else if($y1==$y2) //열이 같은 경우
		{
			$lockarr=$lockarr.$multi_array[($x1+$num)%5][$y1];
			$lockarr=$lockarr.$multi_array[($x2+$num)%5][$y2];
		} 
		else //행, 열 모두 다른경우
		{
			$lockarr=$lockarr.$multi_array[$x2][$y1];
			$lockarr=$lockarr.$multi_array[$x1][$y2];
		}
		// print_r($i.$lockarr."    ");
		// print_r($x1.$y1.$x2.$y2);
	}
	return $lockarr;
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		@import url("css/process.css");
	</style>
</head>
<body>
	<table class="str-table top-table">
		<tr>
			<th>암호키</th>
			<td><?=$prevkey?></td>
		</tr>
		<tr>
			<th>평문</th>
			<td><?=$prevcode?></td>
		</tr>
	</table>
	<table class="board">
		<?=$list?>
	</table>
	<div class="codestrdiv">
		<?=$codestr?>
	</div>
	<table class="str-table">
		<tr>
			<th>암호화된 문자열</th>
			<td><?=$specing_lockarr?></td>
		</tr>
		<tr>
			<th>복호화된 문자열</th>
			<td><?=$decarr?></td>
		</tr>
	</table>
	<div class="button">
		<input type="button"  class="rebutton" onClick="location.href='encryption.php'" value="다시하기">
	</div>
</body>
</html>