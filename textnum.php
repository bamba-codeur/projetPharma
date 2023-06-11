<?php


//$numEnter=["771237680","784250513","765942337","703807010","67duios98","75khd1235","77123"];


//unction islength($element){
	//return strlen($element)==9;
//}

//$isValidNumber=array_filter($numEnter,'islength');
//preg_match_all("#[7][0,5-8][0-9]{7}#", implode("-",$isValidNumber), $TrueNumber);
//print_r($TrueNumber);

$numEnter="7r1237680";
preg_match("#[7][0,5-8][0-9]{7}#",$numEnter,$isnum);

if (!strlen($numEnter)<9 && !$isnum ) {
	echo "le numero saisi est incorrect!";
	
}else{
		echo "le numero est correst";
}

//echo  ($isnum[0]);
