<?

//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// 設定區塊延遲時間 (單位: 毫秒)
define ('SCALE', 0.98);			// 設定區塊間隔	(建議數值: 0.98)
define ('UPPER_HEIGHT', 0.80);		// 設定小字高度	(建議數值: 0.90)

//= [INIT] ========================================================================================================

if (!function_exists('mb_substr')) 
	include CYSUB_SCRIPT_DIR."function\mb_substr.php";

include CYSUB_SCRIPT_DIR."common_1.4.0.php";
include CYSUB_SCRIPT_DIR."function\upper.php";
include CYSUB_SCRIPT_DIR."function\p_code.php";
include CYSUB_SCRIPT_DIR."function\is_japanese.php";

//=============================================== [ Effect Code ] =================================================
$kanji_count = 0;
$japan_count = 0;
$kanji_col[0] = '6D3FF5';
$kanji_col[1] = '0588F2';
$hira_col[0] = '6D3FF5';
$hira_col[1] = '0588F2';
$hira_col[2] = '15306F';
$kanji_i = 0;
$hira_i = 0;
/*
for ($i=0; $i < $objEffectEvent->blockcount; $i++)
{
	if(is_hira($BlockText[$i])){
		$japan_count++;
	}
	else{
		$kanji_count++;
	}
}
*/
for ($i=0; $i < $objEffectEvent->blockcount; $i++)
{
//================================================= [ Part A ] ====================================================
//參數宣告區
//
//	字型大小: $FrontSize			小字大小: $SmallFrontSize
// 	X座標: $Xoffset[$i]			小字X座標: $UpperXoffset[$i]	
// 	Y座標: $Yoffset				小字Y座標: $UpperYoffset
//	整句開始時間: $EventStart		整句結束時間: $EventEnd
// 	單字開始時間: $start[$i]		單字結束時間: $end[$i]		單字經過時間: $offset[$i]
// 	小字開始時間: $UpperStart[$i]		小字結束時間: $UpperEnd[$i]	小字經過時間: $UpperOffset[$i]
// 	主要色彩: $color1	次要色彩: $color2	邊框色彩: $color3	背景色彩: $color4
//
//注意: 1. 有些參數是Array型態, 後面須加[$i]。
//	2. 可使用 mt_rand(a, b) 來產生a, b間亂數。

	$t1 = $start[$i] + $offset[$i] * -5;	
	$t2 = $start[$i] + $offset[$i] * 3;
	$t3 = $start[$i] + $offset[$i] * 5;
	$t4 = $start[$i] + $offset[$i] * 8;
	$t5 = $start[$i] + $offset[$i] * 15;

//================================================= [ Part B ] ====================================================
//與位置相關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. \move 與 \pos 不能同時使用，使用 \move 時需移除原本 \pos 的代碼。
//	2. 盡量不要使用 \an，若要使用請將 Part D 代碼內的 \an5 移除，但位置對齊上有可能會有偏移。
//	3. 以下兩行代碼是作定位用，若不想做其他位置特效，請保留這兩行代碼。

	$s = "{\\pos($Xoffset[$i],$Yoffset)}";
	$Upper = "{\\pos($UpperXoffset[$i],$UpperYoffset)}";

//================================================= [ Part C ] ====================================================
//與位置無關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. 預設特效是卡拉OK以及淡入淡出。
//	2. 為了方便大部分特效的製作，此特效檔以一字一行的方式編寫，因此導致卡拉OK特效與一般寫法有些不同， 
//	   須使用{\\K$PreOffset[$i]}{\\K$offset[$i]}。

	$s .= "{\\fad(300,300)}{\\K$PreOffset[$i]}{\\K$offset[$i]}";
	$Upper .= "{\\fad(300,300)}{\\K$PreUpperOffset[$i]}{\\K$UpperOffset[$i]}";
	if($i==0 || $kanji_i >= 2){
		//shuffle kanji_col
		if(mt_rand(1,100)%2==0){
			$temp = $kanji_col[0];
			$kanji_col[0] = $kanji_col[1];
			$kanji_col[1] = $temp;
		}
		$kanji_i = 0;
	}
	if($i==0 || $hira_i >= 3){
		//shuffle hira_col
		for($j = 0; $j < 5; $j++){
			$temp1 = mt_rand(1,100)%3;
			$temp2 = mt_rand(1,100)%3;
			$temp = $hira_col[$temp1];
			$hira_col[$temp1] = $hira_col[$temp2];
			$hira_col[$temp2] = $temp;
		}
		$hira_i = 0;
	}
	$apply_color = $kanji_col[mt_rand(0,100)%2];
	if($BlockText[$i] != ' ' && is_hira($BlockText[$i])){
		$apply_color = $hira_col[$hira_i++];
	}
	else if($BlockText[$i] != ' '){
		$apply_color = $kanji_col[$kanji_i++];
	}
	//if($japan_count < $kanji_count && is_hira($BlockText[$i])){
		//$apply_color = $kanji_col[2];
	//}
	//if(is_japanese($BlockText[$i])){
	//	$apply_color = $kanji_col[mt_rand(0,100)%3];
	//}
	//else{
	//	$s.="{\\1c&H$apply_color}{\\2c&H$apply_color}";
	//	$Upper .="{\\1c&H$apply_color}{\\2c&H$apply_color}";
	//}
	$gap = 160;
	$randx = mt_rand(8,12);
	$randy = mt_rand(8,12);
	$randz = mt_rand(8,12);
	$rands = mt_rand(120,130);
	if($BlockText[$i] == "fantastic" || $BlockText[$i] == "dreamer"){
		$randx /= 3;
		$randy /= 3;
		$randz /= 3;
		$rands = 105;
		//$s.="{\\bord10}";
	}
	if(mt_rand(1,100)%2 == 0) $randx *= -1;
	if(mt_rand(1,100)%2 == 0) $randy *= -1;
	if(mt_rand(1,100)%2 == 0) $randz *= -1;
	$s.="{\\1c&H$apply_color}{\\2c&H$apply_color}"
		."{\\t(".($start[$i]).",".($start[$i]+$gap).",1,"
		."\\frx$randx\\fry$randy\\frz$randz\\fsc$rands)}"
		."{\\t(".($start[$i]+$gap).",".($start[$i]+2*$gap).",1,"
		."\\frx0\\fry0\\frz0\\fsc100)}";
	$Upper .="{\\1c&H$apply_color}{\\2c&H$apply_color}"
			."{\\t(".($UpperStart[$i]).",".($UpperStart[$i]+$gap).",1,"
		."\\frx$randx\\fry$randy\\frz$randz\\fsc$rands)}"
		."{\\t(".($UpperStart[$i]+$gap).",".($UpperStart[$i]+2*$gap).",1,"
		."\\frx0\\fry0\\frz0\\fsc100)}";

//================================================= [ Part D ] ====================================================
//事件參數設定及儲存
//
//注意: 1. 更改此處可能會影響此特效檔正常運作，若沒有要製作多層字幕特效，請盡量不要修改此部份。

	
	
	
	
	
	
	
	if($color4 == 'FFFFFF' && $i <=3 && $i >= 1){
		//3 sec. hint
		$wid = cySub_GetBlockParam($i, BLOCK_WIDTH) ;
		$half_block = $wid/2;
		$XUP1 = $Xoffset[$i] - $half_block;
		$XUP2 = $Xoffset[$i] + $half_block;
		$YUP1 = $Yoffset-$wid*1.5 - $half_block;
		$YUP2 = $Yoffset-$wid*1.5 + $half_block;
		//$starter[$i] = "{\\pos(".($Xoffset[$i]-40).",".($Yoffset-$wid*1.5+30).")}{\\fsc800}{\\fad(300,300)}"
		//				."{\\bord0}{\\shad0}{\\alpha&H00}"
		//				."{\\clip($XUP1,$YUP1,$XUP2,$YUP2)}{\\t("
		//				.($start[1]-1000*($i)).","
		//				.($start[1]-1000*($i)+500).",1,\\clip($XUP1,$YUP1,$XUP1,$YUP2))}"
		//				."{\\p1}m 0 0 s 10 0 10 10 0 10 c{\\p0}";
		$st1 = $start[1]-1000*($i);
		$en1 =  $start[1]-1000*($i)+800;
		$starter[$i] = "{\\fad(300,300)}{\\3c&HFFFFFF}{\\bord1}{\\shad0}{\\fsc300}{\\blur10}"
					."{\\t(".($en1-300).",".($en1).",1,\\alpha&HFF)}"
					."{\\move(".($Xoffset[$i]-30).",".($Yoffset).","
					.($Xoffset[$i]-30+mt_rand(-20,20)).",".($Yoffset+mt_rand(60,80)).","
					.($st1).",".($en1)."}"
					//."{\\frx".(mt_rand(-90,90))."}"
					//."{\\fry".(mt_rand(-90,90))."}"
					//."{\\frz".(mt_rand(-90,90))."}"
					."{\\t(".($st1).",".($en1).",1,"
					."\\frz".(mt_rand(-10,10)).")}";
		$starter[$i] .= "{\\p1}m 1 0 l 12 -20 13 -20 5 -6 2 0 m 4 -6 l 12 -6 b 20 -18 24 -40 10 -40 b 4 -40 6 -32 8 -32 b 6 -32 8 -40 12 -36 b 16 -28 6 -20 0 -14 l 4 -6{\\p0}";
			
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $starter[$i];
		$objNewEvent -> layer = 10;
		$objNewEvent -> save();
	}
	

//================================================= [ Part E ] ====================================================
//繪圖指令
//
//注意: 1. 以下代碼僅提供撰寫範例，並不會執行。
//	2. 如欲執行以下代碼請將每行代碼開頭的 "//" 移除。
//
	if($i == 1){
		
		$AdjXoffset[$i] = $Xoffset[$i];
		$AdjYoffset = $Yoffset;
		$wid = cySub_GetBlockParam($i, BLOCK_WIDTH) ;
		//$wid = 100;
		$half_block = $wid/2;
		$XUP1 = $Xoffset[$i] - $half_block - 23;
		//$XUP2 = $Xoffset[$i] + $half_block;
		$XUP2 = $XUP1;
		$YUP1 = $Yoffset - 115;
		$YUP2 = $Yoffset + 50;
		
		for ($j=1; $j < $objEffectEvent->blockcount; $j++){
			$XUP2 += cySub_GetBlockParam($j, BLOCK_WIDTH);
		}
		$XUP2 += 20;
		//if($i == 1) $XUP1-=10;
		//if($i == $objEffectEvent->blockcount-1) $XUP2+=10;
		$back = "{\\an5}{\\pos($AdjXoffset[$i],$AdjYoffset)}{\\1c&HFFFFFF}{\\2c&HFFFFFF}{\\bord0}{\\shad0}{\\1a&H66}{\\fsc30000}";
		$back .= "{\\clip($XUP1,$YUP1,$XUP2,$YUP2)}{\\fad(300,300)}";
		$back .= "{\\p1}m 0 0 l 0 12 l 18 15 l 17 -2 {\\p0}";
		
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $back;
		$objNewEvent -> layer = 1;
		$objNewEvent -> save();
	}
	if($BlockText[$i] != ' ' &&($color3!='0000FF' || $i!=1)){
		for($j = 0; $j < cySub_GetBlockParam($i, BLOCK_WIDTH)/45; $j++){
			$wid = cySub_GetBlockParam($i, BLOCK_WIDTH) ;
			$AdjXoffset[$i] = $Xoffset[$i]- $wid/2 + $j*($wid/(cySub_GetBlockParam($i, BLOCK_WIDTH)/45))+mt_rand(-5,5);
			$AdjYoffset = $Yoffset-50;
			$f_end = $start[$i]+mt_rand(1500,1800);
			$feather = "{\\an5}{\\fad(300,300)}{\\3c&HFFFFFF}{\\bord1}{\\shad0}{\\alpha&HFF}{\\fsc200}{\\blur10}{\\t($start[$i],".($start[$i]+50)
						.",1,\\alpha&H11)}"
						."{\\t(".($f_end-300).", $f_end,1,\\alpha&HFF)}"
						."{\\move($AdjXoffset[$i],$AdjYoffset,"
						.($AdjXoffset[$i]+mt_rand(-20,20))
						.",".($AdjYoffset+mt_rand(130,150))
						.",$start[$i],$f_end)}"
						."{\\frx".(mt_rand(-90,90))."}"
						."{\\fry".(mt_rand(-90,90))."}"
						."{\\frz".(mt_rand(-90,90))."}"
						."{\\t(".($start[$i]).",".($start[$i]+$t2).",1,"
						."\\frx".(mt_rand(-90,90))."\\fry".(mt_rand(-90,90))."\\frz".(mt_rand(-90,90)).")}";
			$feather .= "{\\p1}m 1 0 l 12 -20 13 -20 5 -6 2 0 m 4 -6 l 12 -6 b 20 -18 24 -40 10 -40 b 4 -40 6 -32 8 -32 b 6 -32 8 -40 12 -36 b 16 -28 6 -20 0 -14 l 4 -6{\\p0}";
			
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $feather;
			$objNewEvent -> layer = 100;
			$objNewEvent -> save();
		}
	}
	//water fountain animation
	
	$fr = 40;
	$pic[0] = "";
	$pic[1] = "";
	$pic[2] = "";
	$pic[3] = "";
	$pic[4] = "";
	$pic[5] = "";
	$wat[0] = "FF";
	$wat[1] = "D7";
	$wat[2] = "AF";
	$wat[3] = "87";
	$wat[4] = "5F";
	$wat[5] = "27";
	$wat[6] = "F";
	if($i == 1 && $color4 == 'FF0000'){
		//aqua's water
		$s .= "{\\3c&HE0C1FF}{\\t($start[$i], ".($start[$i]+300).", 1, \\bord16\\blur10)}"
			."{\\t($start[$i],".($start[$i]+300).",1,\\1c&HFFCB97\\2c&HFFCB97)}"
			."{\\t(".($start[$i]+1500).",".($start[$i]+3500).",1,\\1c&H$apply_color\\2c&H$apply_color)}";
		$Upper .= "{\\3c&HE0C1FF}{\\t($start[$i], ".($start[$i]+300).", 1, \\bord10\\blur6)}"
			."{\\t($start[$i],".($start[$i]+300).",1,\\1c&HFFCB97\\2c&HFFCB97)}"
			."{\\t(".($start[$i]+1500).",".($start[$i]+3500).",1,\\1c&H$apply_color\\2c&H$apply_color)}";
		$AdjXoffset[$i] = $Xoffset[$i]+300;
		$AdjYoffset = $Yoffset;
		for($j = 0; $j < 6; $j++){
			$pic[$j] = "{\\fad(300,300)}{\\an5}{\\pos($AdjXoffset[$i],$AdjYoffset)}{\\bord0}{\\shad0}{\\alpha&HFF}{\\fscx250}{\\fscy100}"
			."{\\1img(water00"
			.($j%6).".png,200,60)}"
			."";
		}
		for($j = 0; $j < $EventEnd/$fr; $j++){
			$wa = "00";
			if($j <= 6) $wa = $wat[$j];
			$pic[$j%6] .= "{\\t(".($start[$i]+$fr*$j).",".($start[$i]+$fr*$j).",1,\\alpha&H$wa)}";
			$pic[$j%6] .= "{\\t(".($start[$i]+$fr*$j+$fr).",".($start[$i]+$fr*$j+$fr).",1,\\alpha&HFF)}";
			
		}
		for($j = 0; $j < 6; $j++){
			$pic[$j] .= "{\\p1}m -101 -212 l -101 218 l 96 212 l 99 -218  {\\p0}";
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $pic[$j];
			$objNewEvent -> layer = 2;
			$objNewEvent -> save();
		}
	/*
	$fr = 80;
	$pic[0] = "";
	$pic[1] = "";
	$pic[2] = "";
	$pic[3] = "";
	$pic[4] = "";
	$pic[5] = "";
	$pic[6] = "";
	$pic[7] = "";
	$pic[8] = "";
	$pic[9] = "";
	$wat[0] = "FF";
	//$water_a[1] = "D7";
	$wat[1] = "AF";
	//$water_a[2] = "87";
	$wat[2] = "5F";
	$wat[3] = "F";
	if($i == 1 && $color4 == 'FFFFFF'){
		$AdjXoffset[$i] = $Xoffset[$i]+100;
		$AdjYoffset = $Yoffset-200;
		$water_a = 240;
		for($j = 0; $j < 10; $j++){
			$pic[$j] = "{\\fad(300,300)}{\\an5}{\\pos($AdjXoffset[$i],$AdjYoffset)}{\\bord0}{\\shad0}{\\alpha&HFF}{\\fscx6000}{\\fscy8000}"
			."{\\1img(0".(1+$j%2).".png,238,450)}";
		}
		for($j = 0; $j < $EventEnd/$fr; $j++){
			$wa = '00';
			if($j <= 3) $wa = $wat[$j];
			$pic[$j%10] .= "{\\t(".($start[$i]+$fr*$j).",".($start[$i]+$fr*$j).",1,\\alpha&H$wa)}";
			$pic[$j%10] .= "{\\t(".($start[$i]+$fr*$j+$fr).",".($start[$i]+$fr*$j+$fr).",1,\\alpha&HFF)}";
			
		}
		for($j = 0; $j < 10; $j++){
			$pic[$j] .= "{\\p1}m 0 0 l 0 12 l 18 15 l 17 -2 {\\p0}";
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $pic[$j];
			$objNewEvent -> layer = 2;
			$objNewEvent -> save();
		}
		*/
		$AdjXoffset[$i] = $Xoffset[$i];
		$AdjYoffset = $Yoffset;
		$fan = "{\\fad(300,300)}{\\an5}{\\pos($Xoffset[$i],$AdjYoffset)}{\\bord0}{\\shad0}{\\alpha&HFF}{\\fscx15000}{\\fscy10000}"
			."{\\1img(fan4.png,570,-30)}";
		$fan .= "{\\t($start[$i],".($start[$i]+256).",1,\\alpha&H00)}";
		$fan .= "{\\p1}m 0 0 l 0 12 l 18 15 l 17 -2 {\\p0}";
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $fan;
		$objNewEvent -> layer = 3;
		$objNewEvent -> save();
		
	}
	if($i == 1 && $color3 == "0000FF"){
		//explosion
		$s .= "{\\3c&$color4}{\\t($start[$i], ".($start[$i]+300).", 1, \\bord16\\blur10)}"
			."{\\t($start[$i],".($start[$i]+300).",1,\\1c&H00008EA\\2c&H00008EA)}"
			."{\\t(".($start[$i]+1500).",".($start[$i]+3500).",1,\\1c&H$apply_color\\2c&H$apply_color)}"
			."{\\t(".($start[$i]+4000).",".($start[$i]+4100).",1,\\1c&H000000\\2c&H000000\\rnd30\\bord0\\blur10\\alpha33)}";
		$Upper .= "{\\3c&H$color4}{\\t($start[$i], ".($start[$i]+300).", 1, \\bord10\\blur6)}"
			."{\\t($start[$i],".($start[$i]+300).",1,\\1c&H00008EA\\2c&H00008EA)}"
			."{\\t(".($start[$i]+1500).",".($start[$i]+3500).",1,\\1c&H$apply_color\\2c&H$apply_color)}"
			."{\\t(".($start[$i]+4000).",".($start[$i]+4100).",1,\\1c&H000000\\2c&H000000\\rnd30\\bord0\\blur10\\alpha33)}";
		$wid = cySub_GetBlockParam($i, BLOCK_WIDTH) ;
		$starnum = 10;
		$starcol[0] = '00DB00';
		$starcol[1] = 'FF44FF';
		$starcol[2] = 'FFA346';
		$starcol[3] = '9A35FF';
		$starcol[4] = 'FF0086';
		for($j = 0; $j < $starnum; $j++){
			$AdjXoffset[$i] = $Xoffset[$i]+$wid/2-$j*$wid/$starnum+mt_rand(-10,10);
			$AdjYoffset = $Yoffset-30+mt_rand(40,-40);
			$stfad = $start[$i]+2000;
			$starcolap = $starcol[$j%5];
			$star = "{\\fad(300,300)}{\\1c&H$starcolap\\3c&H$starcolap}{\\bord3}{\\blur6}{\\shad0}{\\alpha&HFF}";
			$star .= "{\\t(".($start[$i]+$j*50).",".($start[$i]+$j*50+300).",1,\\alpha00)}";
			$star .= "{\\t(".($stfad-300+$j*50).",".($stfad+$j*50).",1,\\alphaFF)}";
			$star .= "{\\fsc".(mt_rand(200,250))."}";
			$star .= "{\\frx".(mt_rand(30,50))."\\fry".(mt_rand(-30,-50))."}";
			$star .= "{\\move($AdjXoffset[$i],$AdjYoffset,"
					.($AdjXoffset[$i]+mt_rand(-15,-10)).","
					.($AdjYoffset+mt_rand(30,50)).","
					.($start[$i]).","
					.($start[$i]+2000).")}";
			$star .= "{\\t(".($start[$i]).",".($start[$i]+20000).",1,\\frz3600)}";
			
			
			$star .= "{\\p1}m 0 9 l -2 15 l -8 17 l -2 19 l 0 25 l 2 19 l 8 17 l 2 15 {\\p0}";
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $star;
			$objNewEvent -> layer = 30;
			$objNewEvent -> save();
		}
		$cirsc[0] = 2400;
		$cirsc[1] = 1000;
		$cirsc[2] = 1300;
		$cirsc[3] = 1700;
		$cirsc[4] = 2000;
		$cirsc[5] = 1500;
		$cirst = $start[$i]+1000;
		for($j = 0; $j < 6; $j++){
			$cirstap = $cirst+$j*30;
			$AdjXoffset[$i] = $Xoffset[$i];
			$AdjYoffset = $Yoffset-250+40*$j;
			$circle = "{\\fad(300,300)}{\\an5}{\\3c&H$color2}{\\fsc0}{\\1a&HFF}{\\3a&H11}";
			$circle .="{\\bord10}{\\blur3}{\\shad0}{\\pos($AdjXoffset[$i], $AdjYoffset)}";
			$circle .= "{\\frx50}";
			$circle .= "{\\t(".($cirstap).",".($cirstap+100).",1,\\fscx"
			.($cirsc[$j])."\\fscy"
			.($cirsc[$j]/4).")}";
			$circle .= "{\\t(".($cirstap+5000).",".($cirstap+5300).",1,\\fsc0)}"
					."{\\t(".($cirstap).",".($start[$i]+4000).",1,\\bord12)}";
			$circle .= "{\\p1}m 0 0 s 10 0 10 10 0 10 c{\\p0}";
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $circle;
			$objNewEvent -> layer = 30;
			$objNewEvent -> save();
			//fog
			$AdjXoffset[$i] -= $cirsc[$j]/20;
			$fognum = $cirsc[$j]/20;
			for($k=0; $k<$fognum; $k++){
				$fog = "{\\fad(300,300)}{\\jitter(1,1,1,1,1)}{\\an5}{\\3c&H$color2}{\\fsc5}{\\1a&H00}{\\3a&H00}";
				$fog .= "{\\bord10}{\\blur10}{\\shad0}{\\alphaFF}";
				$fog .= "{\\pos(".($AdjXoffset[$i]+$k*$cirsc[$j]/10/$fognum).",".($AdjYoffset+mt_rand(20,-20)).")}";
				//$fog .= "{\\t(".($cirstap+20).",".($cirstap+900).",1,\\alphaAA)}";
				$fog .= "{\\t(".($cirstap+20).",".($cirstap+3000).",1,\\alpha99)}";
				$fog .= "{\\t(".($cirstap+4900).",".($cirstap+5400).",1,\\alphaFF)}";
				$fog .= "{\\p1}m 0 0 s 10 0 10 10 0 10 c{\\p0}";
				$objNewEvent = new SSADialogEvent;
				$objNewEvent -> text = $fog;
				$objNewEvent -> layer = 30;
				$objNewEvent -> save();
			}
		}
		$startst2=$cirst+1000;
		$starnum=7;
		for($j = 0; $j < $starnum; $j++){
			$AdjXoffset[$i] = $Xoffset[$i]+mt_rand(-50,50);
			$AdjYoffset = $Yoffset;
			$stfad = $startst2+1000;
			$st2gap = $j*200;
			$starcolap = $starcol[$j%5];
			$star = "{\\fad(300,300)}{\\1c&H$starcolap\\3c&H$starcolap}{\\bord3}{\\blur6}{\\shad0}{\\alpha&HFF}";
			$star .= "{\\t(".($startst2+$st2gap).",".($startst2+$st2gap+300).",1,\\alpha00)}";
			$star .= "{\\t(".($stfad-300+$st2gap).",".($stfad+$st2gap).",1,\\alphaFF)}";
			$star .= "{\\fsc".(mt_rand(200,250))."}";
			$star .= "{\\frx".(mt_rand(30,50))."\\fry".(mt_rand(-30,-50))."}";
			$star .= "{\\move($AdjXoffset[$i],$AdjYoffset,"
					.($AdjXoffset[$i]+mt_rand(10,-10)).","
					.($AdjYoffset-mt_rand(400,500)).","
					.($startst2+$st2gap).","
					.($startst2+2000+$st2gap).")}";
			$star .= "{\\t(".($startst2).",".($startst2+20000).",1,\\frz3600)}";
			
			
			$star .= "{\\p1}m 0 9 l -2 15 l -8 17 l -2 19 l 0 25 l 2 19 l 8 17 l 2 15 {\\p0}";
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $star;
			$objNewEvent -> layer = 30;
			$objNewEvent -> save();
		}
		$cir2st = $startst2+2000;
		$explo_col[0] = '06D3FF';
		$explo_col[1] = '3C3C3C';
		$cirnum = 20;
		for($j=0; $j<$cirnum; $j++){
			$AdjXoffset[$i] = $Xoffset[$i]-$wid/2+$wid/$cirnum*$j;
			$AdjYoffset = $Yoffset+mt_rand(-50,50);
			$cir_mg = mt_rand(600, 1000);
			$circle = "{\\fad(300,300)}{\\an5}{\\1c&H$explo_col[0]}{\\3c&H$explo_col[0]}{fsc0}{\\alpha&HFF}";//{\\fscy800}{\\fscx1400}
			$circle .="{\\bord6}{\\blur10}{\\shad0}{\\move($AdjXoffset[$i], $AdjYoffset,"
						.($AdjXoffset[$i]+2*mt_rand(-30,30)).",".($AdjYoffset+3*mt_rand(-70,-20)).","
						.($cir2st).",".($EventEnd).")}";
			$circle .= "{\\t(".($cir2st).",".($cir2st+200).",1,\\alpha&H44\\fsc".($cir_mg).")}";
			$circle .= "{\\t(".($cir2st+200).",".($cir2st+700).",1,\\1c&H$explo_col[1]\\3c&H$explo_col[1])}";
			$circle .= "{\\t(".($cir2st+720).",".($EventEnd)."\\fsc".($cir_mg*2).")}";
			$circle .= "{\\p1}m 0 0 s 10 0 10 10 0 10 c{\\p0}";
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $circle;
			$objNewEvent -> layer = 34;
			$objNewEvent -> save();
		}
		
	}
	
	
	
	$s .= "{\\an5}$BlockText[$i]";
	$Upper .= "{\\an5}{\\fs$SmallFrontSize}$upper[$i]";
	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $s;
	$objNewEvent -> layer = 10;
	$objNewEvent -> save();


	if( $UpperStyle[$i] >= 0 )
	{
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $Upper;
		$objNewEvent -> layer = 9;
		$objNewEvent -> save();
	}
	
//
//================================================================================================== by 風梁 ======
}
?> 