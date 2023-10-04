<?

//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// 設定區塊延遲時間 (單位: 毫秒)
define ('SCALE', 1.05);			// 設定區塊間隔	(建議數值: 0.98)
define ('UPPER_HEIGHT', 0.85);		// 設定小字高度	(建議數值: 0.90)
define ('STAR_SIZE', 90);
define ('STAR_OFFSET', 0);

//= [INIT] ========================================================================================================

if (!function_exists('mb_substr')) 
	include CYSUB_SCRIPT_DIR."function\mb_substr.php";

include CYSUB_SCRIPT_DIR."common_1.4.0.php";
include CYSUB_SCRIPT_DIR."function\upper4.php";

//=============================================== [ Effect Code ] =================================================
$last_same = 0;
$last_color = '000000';
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
	/*
	$fix = 100;
	$EventStart = $EventStart + $fix;
	$EventEnd = $EventEnd + $fix;
	$start[$i] = $start[$i] + $fix;
	$end[$i] = $end[$i] + $fix;
	$UpperStart[$i] = $UpperStart[$i] + $fix;
	$UpperOffset[$i] = $UpperOffset[$i] + $fix;
	*/
	$k = $objEffectEvent->blockcount - $i;
	$t1 = $start[$i] + $offset[$i] * -5;	
	$t2 = $start[$i] + $offset[$i] * 3;
	$t3 = $start[$i] + $offset[$i] * 5;
	$t4 = $start[$i] + $offset[$i] * 8;
	$t5 = $start[$i] + $offset[$i] * 15;
	$t6 = $EventStart + 80*$i;
	$t7 = $t6 + 100;
	$t8 = $EventEnd - 60*$k;
	$t9 = $t8 - 200;
	//$t7 = $UpperEnd[$i]
	$StarSize = round($FrontSize*STAR_SIZE/30);
	$x1 = $Xoffset[$i] - round( $screenWidth/30 );
	$color3 = '000000';
//================================================= [ Part B ] ====================================================
//與位置相關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. \move 與 \pos 不能同時使用，使用 \move 時需移除原本 \pos 的代碼。
//	2. 盡量不要使用 \an，若要使用請將 Part D 代碼內的 \an5 移除，但位置對齊上有可能會有偏移。
//	3. 以下兩行代碼是作定位用，若不想做其他位置特效，請保留這兩行代碼。

	$x2[$i]=$Xoffset[$i];
	$y2=$Yoffset;
	$Upperx2[$i]=$UpperXoffset[$i];
	$Uppery2=$UpperYoffset;
	$s = "{\\pos($Xoffset[$i],$Yoffset)}{\\shad0}";
	$Upper = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\shad0}";

	$s2 = "{\\pos($x2[$i],$y2)}{\\shad0}";
	$Upper2 = "{\\pos($Upperx2[$i],$Uppery2)}{\\shad0}";
	
	$clip_fix_x=1.1;
	$clip_fix_y=1.1;
	if($BlockText[$i] >= '0' && $BlockText[$i] <= '9')
		$clip_fix_y=1.5;
	
	$wid = cySub_GetBlockParam($i, BLOCK_WIDTH) ;
	$half_block = $wid/2;
	$XUP1 = $Xoffset[$i] - $half_block*$clip_fix_x;
	$XUP2 = $Xoffset[$i] + $half_block*$clip_fix_x;
	$YUP1 = $Yoffset - $half_block*$clip_fix_y;
	$YUP2 = $Yoffset + $half_block*$clip_fix_y;
	$Xupper1 = $XUP1 - $half_block/2;
	$Xupper2 = $XUP2 + $half_block/2;
	$YupperUP1 = $YUP1 - $half_block*1.5;
	$shad_color = '000000';
	$color5 = '7760E4';
	$color6 = 'B17B29';
	$color7 = $color5;
	$rand_num = mt_rand(1,10);
	if($i != 0 && $BlockText[$i] == ' ' || $BlockText[$i] == '  ') $last_same = $last_same + 1;
	else{
		if($rand_num%2 == 0) $color7 = $color5;
		else $color7 = $color6;
		if($last_same >= 1){
			if($last_color == $color5){
				$color7 = $color6;
			}
			else{
				$color7 = $color5;
			}
			$last_same = 0;
		}
		else{
			if($color7 == $last_color){
				$last_same = $last_same + 1;
			}
			else{
				$last_same = 0;
			}
		}
		$last_color = $color7;
	}
//================================================= [ Part C ] ====================================================
//與位置無關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. 預設特效是卡拉OK以及淡入淡出。
//	2. 為了方便大部分特效的製作，此特效檔以一字一行的方式編寫，因此導致卡拉OK特效與一般寫法有些不同， 
//	   須使用{\\K$PreOffset[$i]}{\\K$offset[$i]}。
	
	$s .= "{\\fad(300,300)}{\\iclip($XUP1,$YUP1,$XUP2,$YUP2)}{\\t($t6,$t7,1,\\iclip($XUP2,$YUP1,$XUP2,$YUP2)}{\\K$PreOffset[$i]}{\\K$offset[$i]}{\\1c&H$color7\\3c&HFFFFFF}";
    $Upper .= "{\\fad(300,300)}{\\iclip($Xupper1,$YupperUP1,$Xupper2,$YUP1)}{\\t($t6,$t7,1,\\iclip($Xupper2,$YupperUP1,$Xupper2,$YUP1)}{\\K$PreUpperOffset[$i]}{\\K$UpperOffset[$i]}{\\1c&H$color7\\3c&HFFFFFF}";	
	//$s2 .= "{\\fad(300,300)}{\\1c&H$color7\\3c&HFFFFFF}";
	//$Upper2 .= "{\\fad(300,300)}{\\1c&H$color7\\3c&HFFFFFF}";

//================================================= [ Part D ] ====================================================
//事件參數設定及儲存
//
//注意: 1. 更改此處可能會影響此特效檔正常運作，若沒有要製作多層字幕特效，請盡量不要修改此部份。

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
	/*
	$s2 .= "{\\an5}$BlockText[$i]";
	$Upper2 .= "{\\an5}{\\fs$SmallFrontSize}$upper[$i]";
	
	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $s2;
	$objNewEvent -> layer = 0;
	$objNewEvent -> save();

	if( $UpperStyle[$i] >= 0 )
	{
		$objNewEvent = new SSADialogEvent;ㄆ
		$objNewEvent -> text = $Upper2;
		$objNewEvent -> layer = 0;
		$objNewEvent -> save();
	}
	*/
//================================================= [ Part E ] ====================================================
//繪圖指令
//
//注意: 1. 以下代碼僅提供撰寫範例，並不會執行。
//	2. 如欲執行以下代碼請將每行代碼開頭的 "//" 移除。
//
	if( $BlockText[$i] != ' ' && $BlockText[$i] != '  ' ){
		for($k=0; $k<3; $k++){
			$AdjXoffset[$i] = $Xoffset[$i]-50;
			$AdjYoffset = $Yoffset - 3;
			$AdjXoffset_2[$i] = $Xoffset[$i]-mt_rand(-50,50);
			$AdjYoffset_2 = $Yoffset - 100;
			$angle = mt_rand(-30,30);
			$size = 200+mt_rand(-10,50);
			$heart = "{\\an5}{\\move($AdjXoffset[$i],$AdjYoffset,$AdjXoffset_2[$i],$AdjYoffset_2)}{\\frz$angle}{\\fsc$size}{\\bord0}{\\blur3}{\\shad0}{\\alpha&HFF}}{\\c&HE0C1FF&}{\\be1}";
			$heart .= "{\\fad(300,300)}{\\t($start[$i],$start[$i],1,\\alpha&H00\\t($t2,$end[$i],1,\\alpha&H88))}";
			$heart .= "{\\p1}m 16 30 b 28 22 30 18 30 14 b 32 8 22 -2 16 10 b 10 -2 0 8 2 14 b 2 18 4 22 16 30{\\p0}";
			
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $heart;
			$objNewEvent -> layer = 1;
			$objNewEvent -> save();
		}
	}
	

//================================================================================================== by 風梁 ======
}
?> 