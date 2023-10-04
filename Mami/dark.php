<?

//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// 設定區塊延遲時間 (單位: 毫秒)
define ('SCALE', 1.05);			// 設定區塊間隔	(建議數值: 0.98)
define ('UPPER_HEIGHT', 0.90);		// 設定小字高度	(建議數值: 0.90)

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
	$t7 = $EventEnd - 300;
	$t8 = $t7 - 70;//退場
	$t9 = $t8-100;
	$t10 = $t9 - 100;
	$t11 = $t10 - 200;
	$trans = $t11 -150;
	$trans2 = $end[$i] +300;
	$rotate = mt_rand(-10, 10);
//================================================= [ Part B ] ====================================================
//與位置相關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. \move 與 \pos 不能同時使用，使用 \move 時需移除原本 \pos 的代碼。
//	2. 盡量不要使用 \an，若要使用請將 Part D 代碼內的 \an5 移除，但位置對齊上有可能會有偏移。
//	3. 以下兩行代碼是作定位用，若不想做其他位置特效，請保留這兩行代碼。

	$s = "{\\pos($Xoffset[$i],$Yoffset)}{\\K$PreOffset[$i]}{\\K$offset[$i]}";
	$Upper = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\K$PreUpperOffset[$i]}{\\K$UpperOffset[$i]}";
	/*
	$sDark = "{\\pos($Xoffset[$i],$Yoffset)}{\\alpha&HFF, \\1cH&000000}";
	$UpperDark = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\alpha&HFF, \\1cH&000000}";
	*/

//================================================= [ Part C ] ===================================================={\\t($end[$i],$trans,1, \\alpha&H88, \\1cH&000000)}
//與位置無關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. 預設特效是卡拉OK以及淡入淡出。
//	2. 為了方便大部分特效的製作，此特效檔以一字一行的方式編寫，因此導致卡拉OK特效與一般寫法有些不同， 
//	   須使用{\\K$PreOffset[$i]}{\\K$offset[$i]}。
	/*
	$s .= "{\\fad(300,300)}{\\t($start[$i],$end[$i]+100,1, \\alpha&H88, \\1cH&000000, \\rnd100, \\frz$rotate)}{\\t($t8,$t7, 1, \\fsc90)}{\\t($t7,$EventEnd, 1, \\fsc200)}";
	$Upper .= "{\\fad(300,300)}{\\t($start[$i],$end[$i]+100,1, \\alpha&H88, \\1cH&000000, \\rnd100, \\frz$rotate)}{\\t($t8,$t7, 1, \\fsc90)}{\\t($t7,$EventEnd, 1, \\fsc200)}";
	*/
	$s .= "{\\fad(300,300)}{\\t($end[$i] ,$trans2,1, \\1cH&000000)}{\\t($trans,$t11,1, \\1cH&000000, \\alpha&H88, \\rnd100, \\frz$rotate)}{\\t($t8,$t7, 1, \\fsc90)}{\\t($t7,$EventEnd, 1, \\fsc200)}";
	$Upper .= "{\\fad(300,300)}{\\t($end[$i] ,$trans2,1, \\1cH&000000)}{\\t($trans,$t11,1, \\1cH&000000, \\alpha&H88, \\rnd100, \\frz$rotate)}{\\t($t8,$t7, 1, \\fsc90)}{\\t($t7,$EventEnd, 1, \\fsc200)}";
	/*
	$sDark .= "{\\t($start[$i],$end[$i]+100,1, \\alpha&H88)}";
	$UpperDark .= "{\\t($start[$i],$end[$i]+100,1, \\alpha&H88)}";
	
	*/
//================================================= [ Part D ] ====================================================, \\rnd100
//事件參數設定及儲存
//
//注意: 1. 更改此處可能會影響此特效檔正常運作，若沒有要製作多層字幕特效，請盡量不要修改此部份。

	$s .= "{\\an5}$BlockText[$i]";
	$Upper .= "{\\an5}{\\fs$SmallFrontSize}$upper[$i]";

	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $s;
	$objNewEvent -> layer = 2;
	$objNewEvent -> save();


	if( $UpperStyle[$i] >= 0 )
	{
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $Upper;
		$objNewEvent -> layer = 2;
		$objNewEvent -> save();
	}
	/*
	$sDark .= "{\\an5}$BlockText[$i]";
	$UpperDark .= "{\\an5}{\\fs$SmallFrontSize}$upper[$i]";
	
	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $sDark;
	$objNewEvent -> layer = 1;
	$objNewEvent -> save();

	if( $UpperStyle[$i] >= 0 )
	{
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $UpperDark;
		$objNewEvent -> layer = 1;
		$objNewEvent -> save();
	}
	*/
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