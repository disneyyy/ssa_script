<?

//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// 設定區塊延遲時間 (單位: 毫秒)
define ('SCALE', 0.95);			// 設定區塊間隔	(建議數值: 0.98)
define ('UPPER_HEIGHT', 0.70);		// 設定小字高度	(建議數值: 0.90)

//= [INIT] ========================================================================================================

if (!function_exists('mb_substr')) 
	include CYSUB_SCRIPT_DIR."function\mb_substr.php";

include CYSUB_SCRIPT_DIR."common_1.4.0.php";
include CYSUB_SCRIPT_DIR."function\upper.php";

//=============================================== [ Effect Code ] =================================================

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
	
	
	$fix = 100;
	$start[$i] -= $fix;
	$end[$i] -= $fix;
	$UpperStart[$i] -= $fix;
	$UpperEnd[$i] -= $fix;
//================================================= [ Part B ] ====================================================
//與位置相關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. \move 與 \pos 不能同時使用，使用 \move 時需移除原本 \pos 的代碼。
//	2. 盡量不要使用 \an，若要使用請將 Part D 代碼內的 \an5 移除，但位置對齊上有可能會有偏移。
//	3. 以下兩行代碼是作定位用，若不想做其他位置特效，請保留這兩行代碼。
	
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
	$s = "{\\pos($Xoffset[$i],$Yoffset)}{\\1vc($color[0],$color[1],$color[2],$color[3])}{\\2vc(FFFFFF,FFFFFF,FFFFFF,FFFFFF)}";
	$Upper = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\1vc($color[0],$color[1],$color[2],$color[3])}{\\2vc(FFFFFF,FFFFFF,FFFFFF,FFFFFF)}";

	$s2 = "{\\pos($Xoffset[$i],$Yoffset)}{\\1vc($color[0],$color[1],$color[2],$color[3])}{\\2vc(FFFFFF,FFFFFF,FFFFFF,FFFFFF)}";
	$Upper2 = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\1vc($color[0],$color[1],$color[2],$color[3])}{\\2vc(FFFFFF,FFFFFF,FFFFFF,FFFFFF)}";

//================================================= [ Part C ] ===================================================={\\t($end[$i],$end[$i]+$t7,1,\\1va(FFFFFF,FFFFFF,FFFFFF,FFFFFF)\\2va(FFFFFF,FFFFFF,FFFFFF,FFFFFF)\\3va(FFFFFF,FFFFFF,FFFFFF,FFFFFF)\\4va(FFFFFF,FFFFFF,FFFFFF,FFFFFF)
//與位置無關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. 預設特效是卡拉OK以及淡入淡出。
//	2. 為了方便大部分特效的製作，此特效檔以一字一行的方式編寫，因此導致卡拉OK特效與一般寫法有些不同， 
//	   須使用{\\K$PreOffset[$i]}{\\K$offset[$i]}。

	$t7 = 1000;
	$t91=$end[$i]+$t7;
	$scaleT='88';
	$t9 = $EventEnd - 300;
	$t8 = $t9 - 70;
	$s .= "{\\fad(300,300)}{\\K$PreOffset[$i]}{\\K$offset[$i]}{\\t($t8,$t9, 1, \\fsc90)}{\\t($t9,$EventEnd, 1, \\fsc200)}";
	$Upper .= "{\\fad(300,300)}{\\K$PreUpperOffset[$i]}{\\K$UpperOffset[$i]}{\\t($t8,$t9, 1, \\fsc90)}{\\t($t9,$EventEnd, 1, \\fsc200)}";

	$tmid = ($start[$i]+$end[$i])/2;
	$s2 .= "{\\fad(300,300)}{\\t($start[$i],$end[$i],1,\\bord7}{\\t($tmid,$end[$i], 1, \\fsc200, \\alpha&HFF)}";
	$Upper2 .= "{\\fad(300,300)}{\\t($start[$i],$end[$i],1,\\bord7}{\\t($tmid,$end[$i], 1, \\alpha&HFF)}";

//================================================= [ Part D ] ===================================================={\\t($start[$i],$end[$i],1,\\bord7}{\\t($tmid,$end[$i], 1, \\fsc200, \\alpha&HFF)}
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

	$s2 .= "{\\an5}$BlockText[$i]";
	$Upper2 .= "{\\an5}{\\fs$SmallFrontSize}$upper[$i]";

	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $s2;
	$objNewEvent -> layer = 1;
	$objNewEvent -> save();


	if( $UpperStyle[$i] >= 0 )
	{
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $Upper2;
		$objNewEvent -> layer = 0;
		$objNewEvent -> save();
	}

//================================================= [ Part E ] ====================================================
//繪圖指令
//
//注意: 1. 以下代碼僅提供撰寫範例，並不會執行。
//	2. 如欲執行以下代碼請將每行代碼開頭的 "//" 移除。
//
//	$AdjXoffset[$i] = $Xoffset[$i] - 7;
//	$AdjYoffset = $Yoffset - 3;
//
//	$star = "{\\an5}{\\pos($AdjXoffset[$i],$AdjYoffset)}{\\bord0}{\\shad0}{\\fscx90\\fscy90}{\\alpha&HFF}}{\\c&H$color4&}{\\be1}";
//	$star .= "{\\t($start[$i],$start[$i],1,\\alpha&H00\\t($t2,$end[$i],1,\\alpha&HFF))}";
//	$star .= "{\\p1}m 10 49 l 52 19 0 19 42 49 26 0{\\p0}";
//	
//	$objNewEvent = new SSADialogEvent;
//	$objNewEvent -> text = $star;
//	$objNewEvent -> layer = $i+2;
//	$objNewEvent -> save();
//
//================================================================================================== by 風梁 ======
}
?> 