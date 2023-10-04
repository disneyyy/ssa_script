<?

//= [CONFIG] ======================================================================================================


//= [INIT] ========================================================================================================

function butayaro_color($color1, $color2){
//=============================================== [ Effect Code ] =================================================

	
	$t7 = 5000;
	$fix = 100;
	
	$color[0] = $color2;
	$color[1] = $color2;
	$color[2] = $color2;
	$color[3] = $color2;
	$c=4;
	for( $jj = 0; $jj < 4 ;$jj++){
		$a=mt_rand(0,2);
		if($a <=1){
			$color[$jj] = $color1;
			$c--;
		}			
	}
	if($color[0] == $color[1] && $color[0] == $color[2] && $color[0] == $color[3]){
		if($color[0] == $color2){
			$color[mt_rand(0,3)] = $color1;
			$c--;
		}else{
			$color[mt_rand(0,3)] = $color2;
			$color[mt_rand(0,3)] = $color2;
		}
	}
	if($c == 3){
		$a = mt_rand(0,3);
		while($color[$a] != $color2){
			$a = mt_rand(0,3);
		}
		$color[$a] = $color1;
	}
return "{\\1vc($color[0],$color[1],$color[2],$color[3])}";
}
?> 