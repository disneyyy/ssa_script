<?

//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// 設定區塊延遲時間 (單位: 毫秒)
define ('SCALE', 1.05);			// 設定區塊間隔	(建議數值: 0.98)
define ('UPPER_HEIGHT', 0.60);		// 設定小字高度	(建議數值: 0.90)
define ('STAR_SIZE', 90);
define ('STAR_OFFSET', 0);

//= [INIT] ========================================================================================================

if (!function_exists('mb_substr')) 
	include CYSUB_SCRIPT_DIR."function\mb_substr.php";

include CYSUB_SCRIPT_DIR."common_1.4.0.php";
include CYSUB_SCRIPT_DIR."function\upper.php";
function randNum($b, $n1, $n2){
	while(true){
		$a=mt_rand($n1, $n2);
		if($a!=$b)
			return $a;
	}
}

//=============================================== [ Effect Code ] =================================================
$b=0;
$a=0;
$d=0;
$e=0;
$c[0]='03EFFC';//Ai
$c[1]='3333FF';//Rika
$c[2]='80FF00';//Neiru
$c[3]='FF8000';//Momoe
$last = $c[3];
for ($i=0; $i < $objEffectEvent->blockcount; $i++)
{
	//$rand = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f');
	if($color3=='FFFFFF'){
		$scale2 = 'AA';
		$scale4 = '44';
		$last = $c[3];
		if($i%4==0){
			for($j=0; $j<=5; $j++){
				$a=mt_rand(0, 3);
				$b=randNum($d, 0, 3);
				$temp = $c[$d];
				$c[$d] = $c[$b];
				$c[$b] = $temp;
			}
		}
		if($last == $c[0]){
			$temp = $c[0];
			$c[0] = $c[1];
			$c[1] = $temp;
		}
		$num = $i%4;
		$color5 = $c[$num];
		/*
		switch($b){//FF0000藍、00FF00綠、0000FF紅
			case 1:
				$color5 = '0000FF';//紅
				break;
			case 2:
				$color5 = '00BB00';//綠
				break;
			case 3:
				$color5 = 'C60000';//藍
				break;
			case 4:
				$color5 = '00F9F9';//黃
				break;
			case 5:
				$color5 = '91004B';//紫
				break;
			case 6:
				$color5 = '0080FF';//橙
				break;
			case 7:
				$color5 = '03EFFC';//Ai
				break;
			case 8:
				$color5 = '3333FF';//Rika
				break;
			case 9:
				$color5 = '80FF00';//Neiru
				break;
			case 10:
				$color5 = 'FF8000';//Momoe
				break;
		}
		*/
		//$color5 = ''.$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];//自己找色票再用rand、switch
	}
	else
	{
		$scale2 = '00';
		$scale4 = '44';
		$color5 = $color3;
	}
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
	$t6 = $end[$i] + 0;
	if($t6 > $start[$i] + 300)
		$t6 = $start[$i] + 300;
	$StarSize = round($FrontSize*STAR_SIZE/30);
	$x1 = $Xoffset[$i] - round( $screenWidth/30 );
//	$x1 = $Xoffset[$i];
//================================================= [ Part B ] ====================================================
//與位置相關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. \move 與 \pos 不能同時使用，使用 \move 時需移除原本 \pos 的代碼。
//	2. 盡量不要使用 \an，若要使用請將 Part D 代碼內的 \an5 移除，但位置對齊上有可能會有偏移。
//	3. 以下兩行代碼是作定位用，若不想做其他位置特效，請保留這兩行代碼。
	$nx = 6;
	$ny = 4;
	$nux = 4;
	$nuy = 3;
	$x2[$i]=$Xoffset[$i]+$nx;
	$y2=$Yoffset+$ny;
	$Upperx2[$i]=$UpperXoffset[$i]+$nux;
	$Uppery2=$UpperYoffset+$nuy;
	$s = "{\\pos($Xoffset[$i],$Yoffset)}{\\shad4}{\\2a&H$scale2}{\\4a&H$scale4}{\\1a&H$scale2}";
	$Upper = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\shad4}{\\2a&H$scale2}{\\4a&H$scale4}{\\1a&H$scale2}";
	$s2 = "{\\pos($x2[$i],$y2)}{\\1c&H000000}{\\shad0}{\\bord0}";
	$Upper2 = "{\\pos($Upperx2[$i],$Uppery2)}{\\1c&H000000}{\\shad0}{\\bord0}";
//{\\2a&H$scalee}{\\4a&H$scalee}
//================================================= [ Part C ] ====================================================
//與位置無關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. 預設特效是卡拉OK以及淡入淡出。
//	2. 為了方便大部分特效的製作，此特效檔以一字一行的方式編寫，因此導致卡拉OK特效與一般寫法有些不同， 
//	   須使用{\\K$PreOffset[$i]}{\\K$offset[$i]}。
	
	$s .= "{\\fad(300,300)}{\\t($start[$i],$t6,1,\\3a&HFF,\\4a&HFF, \\1a&H00)}";
	$Upper .= "{\\fad(300,300)}{\\t($start[$i],$t6,1,\\3a&HFF,\\4a&HFF, \\1a&H00)}";
	$s2 .= "{\\fad(300,300)}";
	$Upper2 .= "{\\fad(300,300)}";
//{\\t($start[$i],$t4,1,\\2a&H$scalee\\4a&H$scalee)}
//{\\t($t3,$EventEnd,1,\\3a&HFF,\\4a&HFF, \\shad2)}
//{\\K$PreOffset[$i]}{\\K$offset[$i]}
//{\\K$PreUpperOffset[$i]}{\\K$UpperOffset[$i]}
//================================================= [ Part D ] ====================================================
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
		$objNewEvent -> layer = 1;
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
	$AdjXoffset[$i] = $Xoffset[$i] - STAR_OFFSET;
	$AdjYoffset = $Yoffset - 2;
	$x1 = $AdjXoffset[$i];
	$y1 = $AdjYoffset+mt_rand(-20, 10);
	$rotate = mt_rand(-45, 45);
	
	
//	$color5 = 'FFFFFF';
//
	$star = "{\\fad(300,300)}{\\an7}{\\pos($x1,$y1)}{\\alpha&HFF}{\\bord0}{\\shad0}{\\2a&H$scale2}{\\frz$rotate}{\\fscx$StarSize\\fscy$StarSize\\fry0}{\\1c&H$color5&}{\\be1}";
	$star .= "{\\t($start[$i],$start[$i],1,\\alpha&H00)}{\\t($t3,$EventEnd,1,\\alpha&H00)}";
//	$star .= "{\\t($start[$i],$start[$i],1,\\alpha&H00\\t($t2,$end[$i],1,\\alpha&HFF))}";
//	$star = "{\\an5}{\\pos($AdjXoffset[$i],$AdjYoffset)}{\\bord0}{\\shad0}{\\fscx$StarSize\\fscy$StarSize\\fry0}{\\alpha&HFF}}{\\c&H$color5&}{\\be1}";
	$e=randNum($e, 1, 3);
	switch($e){
		case 0:
			$star .= "{\\p1}m 0 7 b 0 0 0 -5 0 -17 b 0 -17 0 -17 0 -21 b -3 -31 -3 -9 -6 -7 b -9 -5 -15 -17 -18 -14 b -21 -14 -6 -5 -12 -2 b -18 -2 -18 -5 -25 -2 b -28 0 -6 -2 -15 5 b -18 7 -31 19 -12 7 b -6 2 -15 17 -6 9 b 0 7 -12 24 -6 21 b -3 19 -3 14 0 12 b 6 9 6 21 13 19 b 16 17 0 9 9 9 b 16 9 31 7 16 7 b 0 7 16 5 9 2 b 6 0 31 -7 22 -7 b 16 -7 3 5 6 -5 b 6 -17 0 2 -1 -19  {\\p0}";
			break;
		case 1:
			$star .= "{\\p1}m 13 -3 b 25 -8 4 -6 10 -12 b 12 -22 5 -15 0 -12 b -26 -20 1 -6 -16 -11 b -24 -10 -18 -6 -16 -6 b -7 -2 -28 6 -16 5 b -12 4 -7 4 -9 8 b -12 14 -11 18 -8 15 b 1 1 6 23 8 16 b 9 11 9 9 7 9 b 6 5 18 8 9 4 b 12 3 24 5 19 1  {\\p0}";
			//$star .= "{\\p1}m 15 -3 b 30 -9 4 -7 12 -14 b 14 -26 5 -17 -1 -14 b -32 -23 1 -6 -20 -12 b -30 -11 -23 -7 -20 -6 b -9 -2 -34 8 -20 7 b -15 6 -9 6 -11 10 b -15 18 -14 23 -10 19 b 1 2 7 28 9 20 b 10 14 10 12 8 11 b 7 7 21 10 10 6 b 14 4 29 7 22 2 {\\p0}";
			break;
		case 2:
			$star .= "{\\p1}m 0 1 b -3 -2 -5 -4 -8 -7 b -8 -7 -8 -7 -8 -7 b 0 -4 7 -13 6 -8 b 3 -2 19 -4 10 1 b 3 2 14 12 5 9 b -4 5 -10 13 -8 8 b -6 2 -16 2 -11 1 b -14 -7 -9 -4 -8 -7 b -7 -6 -6 -5 -5 -4  {\\p0}";
			break;
		case 3:
			$star .= "{\\p1}m 0 2 b 7 -2 2 -11 2 -17 b -3 -4 -3 -13 -6 -9 b -10 -12 -16 -16 -14 -12 b -14 -8 -6 -6 -13 -2 b -19 1 -23 5 -16 6 b -7 7 -3 5 -6 10 b -9 15 -5 24 -1 15 b 3 5 6 12 8 13 b 17 20 15 10 11 6 b 6 2 24 3 15 -1 b 4 -1 28 -13 17 -12 b 10 -9 7 -8 6 -8 b 4 -12 6 -23 2 -17  {\\p0}";
			break;
		case 4:
			$star .= "{\\p1}m 0 8 b 5 0 1 -2 1 -9 b 1 -17 0 -23 -1 -19 b -3 -13 0 -6 -3 -7 b -4 -11 -7 -15 -7 -11 b -7 -10 -3 -5 -7 -7 b -8 -9 -11 -11 -9 -7 b -7 -5 -7 -2 -11 -3 b -14 -6 -26 -9 -22 -6 b -14 -3 -5 2 -12 0 b -13 0 -14 -1 -16 0 b -17 2 -14 2 -12 2 b -7 2 -11 3 -12 3 b -14 4 -12 6 -9 4 b -4 2 -12 7 -8 7 b -3 4 -11 11 -8 11 b 0 6 -9 15 -5 20 b -3 22 -4 12 -3 10 b -1 6 0 20 1 10 b 1 7 4 8 4 12 b 5 19 6 14 5 10 b 4 6 11 18 11 14 b 10 10 5 4 11 7 b 17 10 11 6 10 4 b 6 2 27 4 23 2 b 15 0 6 0 17 -5 b 21 -7 11 -3 8 -2 b 5 -2 13 -10 9 -7 b 6 -5 4 -3 4 -5 b 6 -9 10 -14 4 -9 b 1 -6 1 -6 1 -7 b 1 -10 0 -11 0 -13 {\\p0}";
			break;
	}
	//if( $BlockText[$i] != ' ' && $BlockText[$i] != '  ')
	//{
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $star;
		$objNewEvent -> layer = 0;
		$objNewEvent -> save();
	//}
//
//================================================================================================== by 風梁 ======
}
?> 