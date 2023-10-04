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

//================================================= [ Part C ] ===================================================={\\t($end[$i],$end[$i]+$t7,1,\\1va(FFFFFF,FFFFFF,FFFFFF,FFFFFF)\\2va(FFFFFF,FFFFFF,FFFFFF,FFFFFF)\\3va(FFFFFF,FFFFFF,FFFFFF,FFFFFF)\\4va(FFFFFF,FFFFFF,FFFFFF,FFFFFF)
//與位置無關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. 預設特效是卡拉OK以及淡入淡出。
//	2. 為了方便大部分特效的製作，此特效檔以一字一行的方式編寫，因此導致卡拉OK特效與一般寫法有些不同， 
//	   須使用{\\K$PreOffset[$i]}{\\K$offset[$i]}。

	$t7 = 1000;
	$t91=$end[$i]+$t7;
	$scaleT='88';
	$s .= "{\\fad(300,300)}{\\K$PreOffset[$i]}{\\K$offset[$i]}";
	$Upper .= "{\\fad(300,300)}{\\K$PreUpperOffset[$i]}{\\K$UpperOffset[$i]}";

//================================================= [ Part D ] ====================================================
//事件參數設定及儲存
//
//注意: 1. 更改此處可能會影響此特效檔正常運作，若沒有要製作多層字幕特效，請盡量不要修改此部份。

	$s .= "{\\an5}$BlockText[$i]";
	$Upper .= "{\\an5}{\\fs$SmallFrontSize}$upper[$i]";

	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $s;
	$objNewEvent -> layer = 1;
	$objNewEvent -> save();


	if( $UpperStyle[$i] >= 0 )
	{
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $Upper;
		$objNewEvent -> layer = 0;
		$objNewEvent -> save();
	}

//================================================= [ Part E ] ====================================================
//繪圖指令
//
//注意: 1. 以下代碼僅提供撰寫範例，並不會執行。
//	2. 如欲執行以下代碼請將每行代碼開頭的 "//" 移除。
//
	
	$t7 = 1000;
	$t91=$end[$i]+$t7;
	$t92=$EventEnd-$t7;
	for($j= 0; $j< 5&&  $BlockText[$i] != ' ' && $BlockText[$i] != '  ' && $BlockText[$i] != ''; $j++)
	{	
	$rotate=mt_rand(-120,-45);				//XZ旋轉角度(原狀態)
	$d=mt_rand(-50,45);					//X偏移
	$e=mt_rand(-50,30);					//Y偏移
	$scale2end=mt_rand(20,130);				//血跡伸縮(末)
	$scale=mt_rand(50,135);					//血跡伸縮
	$AdjXoffset[$i] = $Xoffset[$i] - $d -10;			//繪圖相對字偏移
	$AdjYoffset = $Yoffset - $e;				//繪圖相對字偏移
	$lalpha[1]="77";						//宣告5種透明度
	$lalpha[2]="11";
	$lalpha[3]="55";
	$lalpha[4]="33";
	$lalpha[5]="44";
	$k=mt_rand(1,5);						
	
	$blooda = "{\\fad(300,300)}{\\an7}{\\pos($AdjXoffset[$i],$AdjYoffset)}{\\bord0}{\\shad0}{\\fscx$scale\\fscy$scale}{\\frx$rotate\\frz$rotate}{\\alpha&HFF}{\\c&0000AE}{\\be1}";
	$blooda .="{\\t($start[$i],$end[$i],1,\\alpha&$lalpha[$k])}";
	$blooda .="{\\p1}m 0 0 b -3 0 -5 -6 -2 -15 b 0 -19 1 -20 3 -15 b 5 -9 4 1 0 0 {\\p0}";
		//(繞中心)(位置)(外框)(陰影)(XY方向伸縮)(XZ方向旋轉)(整個字體透明度)(字體顏色)
		//(時間函數:期間、加速度、末狀態)
		//(繪圖指令)		

	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $blooda;
	$objNewEvent -> layer = 35;
	$objNewEvent -> save();
	}
	for($j= 0; $j< 3&&  $BlockText[$i] != ' ' && $BlockText[$i] != '  ' && $BlockText[$i] != ''; $j++)
	{	
	$rotate=mt_rand(-45,0);					//XZ旋轉角度(原狀態)
	$d=mt_rand(-50,30);					//XY偏移
	$scale2end=mt_rand(20,110);				//血跡伸縮(末)
	$scale=mt_rand(50,125);					//血跡伸縮
	$AdjXoffset[$i] = $Xoffset[$i] - $d -10;			//繪圖相對字偏移
	$AdjYoffset = $Yoffset - $d;				//繪圖相對字偏移

	$lalpha[1]="99";						//宣告5種透明度
	$lalpha[2]="77";
	$lalpha[3]="55";
	$lalpha[4]="33";
	$lalpha[5]="11";
	$k=mt_rand(1,5);						

	
	$bloodc = "{\\fad(300,300)}{\\an5}{\\pos($AdjXoffset[$i],$AdjYoffset)}{\\bord0}{\\shad0}{\\fscx$scale\\fscy$scale}{\\frx$rotate\\frz$rotate}{\\alpha&HFF}{\\c&0000AE}{\\be1}";
	$bloodc .="{\\t($start[$i],$end[$i],1,\\alpha&$1alpha[$k])}";
	$bloodc .="{\\p1}m 0 0 b 0 0 0 0 0 0 b -3 -3 2 -4 4 -10 b -2 -11 1 -14 8 -14 b 12 -15 12 -12 16 -11 b 20 -11 18 -14 20 -15 b 24 -18 31 -15 27 -12 b 25 -9 14 -9 18 -6 b 21 -4 20 -2 20 -1 b 20 0 20 1 12 -2 b 8 0 5 8 0 0 {\\p0}";
		//(繞中心)(位置)(外框)(陰影)(XY方向伸縮)(XZ方向旋轉)(整個字體透明度)(字體顏色)
		//(時間函數:期間、加速度、末狀態)
		//(繪圖指令)		

	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $bloodc;
	$objNewEvent -> layer = 32;
	$objNewEvent -> save();
	}
//
//================================================================================================== by 風梁 ======
}
?> 