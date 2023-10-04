<?
header('Content-Type: text/html; charset=utf-8');
//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// ����ҿ������� (�Ű�: ����)
define ('SCALE', 0.9);			// ����ҿ���ֳ�	(������?: 0.98)
define ('UPPER_HEIGHT', 0.75);		// ���꾮������	(������?: 0.90)

//= [INIT] ========================================================================================================

if (!function_exists('mb_substr')) 
	include CYSUB_SCRIPT_DIR."function\mb_substr.php";

include CYSUB_SCRIPT_DIR."common_1.4.0.php";
include CYSUB_SCRIPT_DIR."function\upper.php";

//=============================================== [ Effect Code ] =================================================
$try=0;
$last=9;

$V_factor=1;
$V=$V_factor*$objEffectEvent->blockcount;
$V_compute=$V*$V_factor;
$clip_duration=500;
$max_speed=20;
$tclipstart=$EventStart;
$accu_time=0;
for($i=0; $i < $objEffectEvent->blockcount; $i++){
	$V_compute=$V*$V/$V_factor;
	$time_slice=$clip_duration/$V_compute;
	if($time_slice < $max_speed) $time_slice = $max_speed;
	$accu_time+=$time_slice;
	$V-=1;
}
$V=$V_factor*$objEffectEvent->blockcount;
$tclipstart2=$EventEnd-$accu_time;
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
	if($objEffectEvent->blockcount == 16 && $BlockText[6] == '何' && $BlockText[6] == '?' && $BlockText[7] == ' ' && $BlockText[15] == '?'){
		// 何が悪いの? 嫉妬でしょうか?
		$start[12]=$start[11];
		$start[13]=$start[11];
		$end[11]=$end[13];
		$end[12]=$end[13];
	}
	*/
	if($BlockText[$i]=='っ' ||$BlockText[$i]=='ー' || $BlockText[$i]=='!' || $BlockText[$i]=='?' || $BlockText[$i]=='…' || $BlockText[$i]=='ュ' || $BlockText[$i]=='ッ' || $BlockText[$i] == '”' || $BlockText[$i] == '。' && $i > 0){
		//跟隨前一個
		$index=$i-1;
		$start[$i]=$start[$index];
		$end[$index]=$end[$i];
	}
	$index=$i+1;
	if($i < $objEffectEvent->blockcount-1 && $BlockText[$i+1]=='ょ'){
		//しょう
		$start[$i+1]=$start[$i];
		$end[$i]=$end[$i+1];
		if($i+2 < $objEffectEvent->blockcount && $BlockText[$i+2]=='う'){
			$start[$i+2]=$start[$i];
			$end[$i]=$end[$i+2];
			$index2=$i+1;
			$end[$index2]=$end[$i+2];
		}
	}
	if($i < $objEffectEvent->blockcount-1 && $BlockText[$i+1]=='ゃ'){
		//しょう
		$start[$i+1]=$start[$i];
		$end[$i]=$end[$i+1];
		if($i+2 < $objEffectEvent->blockcount && $BlockText[$i+2]=='う'){
			$start[$i+2]=$start[$i];
			$end[$i]=$end[$i+2];
			$index2=$i+1;
			$end[$index2]=$end[$i+2];
		}
	}
	if($i>0 && $BlockText[$i]=='愛' && $BlockText[$i-1]=='可'){
		//可愛
		$index=$i-1;
		$start[$i]=$start[$index];
		$end[$index]=$end[$i];
	}
	if($objEffectEvent->blockcount == 13 && $BlockText[1] == '貴' && $BlockText[4] == '貴'){
		//貴安
		$start[2]=$start[1];
		$end[1]=$end[2];
		$start[5]=$start[4];
		$end[4]=$end[5];
	}
	if($objEffectEvent->blockcount-1 == $i+1 && $BlockText[$i+1] == 'い'){
		//Xい
		$start[$i+1]=$start[$i];
		$end[$i]=$end[$i+1];
	}
	if($objEffectEvent->blockcount == 13 && $BlockText[1] == '類' && $BlockText[2] == 'は' && $BlockText[$i] == '言'){
		//言う
		$start[$i+1]=$start[$i];
		$end[$i]=$end[$i+1];
	}
	$V_compute=$V*$V/$V_factor;
	$time_slice=$clip_duration/$V_compute;
	if($time_slice < $max_speed) $time_slice = $max_speed;
	$tclipend=$tclipstart+$time_slice;
	$tclipend2=$tclipstart2+$time_slice;
	$V-=1;
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
	//$StarSize = round($FrontSize*STAR_SIZE/30);
	$x1 = $Xoffset[$i] - round( $screenWidth/30 );
	//$start[$i] = $start[$i] - 1000;
	//$end[$i] = $end[$i] - 1000;
	
	
	$clip_fix_x=1.1;
	$clip_fix_y=1;
	$clip_upper_fix_x=1;
	$clip_upper_fix_y=1;
	if($BlockText[$i] == '?' || $BlockText[$i] == '!' || $BlockText[$i] == '…'){
		$clip_fix_y=1.6;
		$clip_fix_x=1.5;
	}
	if($BlockText[$i] == '渉'){
		$clip_upper_fix_x=1.5;
		$clip_upper_fix_y=1;
	}
	$wid = cySub_GetBlockParam($i, BLOCK_WIDTH) ;
	$half_block = $wid/2;
	$XUP1 = $Xoffset[$i] - $half_block*$clip_fix_x;
	$XUP2 = $Xoffset[$i] + $half_block*$clip_fix_x;
	$YUP1 = $Yoffset - $half_block*$clip_fix_y;
	$YUP2 = $Yoffset + $half_block*$clip_fix_y;
	$Xupper1 = $XUP1 - $half_block/2*$clip_upper_fix_x;
	$Xupper2 = $XUP2 + $half_block/2*$clip_upper_fix_x;
	$YupperUP1 = $YUP1 - $half_block*1.5*$clip_upper_fix_y;
//================================================= [ Part B ] ====================================================
//與位置相關的特效代碼 ( $s為原句特效, $Upper為小字特效 )
//
//注意: 1. \move 與 \pos 不能同時使用，使用 \move 時需移除原本 \pos 的代碼。
//	2. 盡量不要使用 \an，若要使用請將 Part D 代碼內的 \an5 移除，但位置對齊上有可能會有偏移。
//	3. 以下兩行代碼是作定位用，若不想做其他位置特效，請保留這兩行代碼。

	
	$Ydown=$Yoffset+10;
	$Yupperdown=$UpperYoffset+10;
	$tdown1=$start[$i]+100;
	$tdown2=$tdown1+100;
	if($BlockText[$i] != 'Chu!'){
		$sfirst = "{\\move($Xoffset[$i],$Yoffset,$Xoffset[$i],$Ydown,$start[$i],$tdown1)}{\\iclip($XUP1,$YUP1,$XUP2,$YUP2)}{\\4c&H9A35FF}{\\shad5}{\\1c&H$color2}{\\alpha&H00}";
		$sfirst .= "{\\t($tclipstart,$tclipend,1,\\iclip($XUP2,$YUP1,$XUP2,$YUP2)}{\\t($tdown1,$tdown1,1,\\alpha&HFF)}";
		$s = "{\\move($Xoffset[$i],$Ydown,$Xoffset[$i],$Yoffset,$tdown1,$tdown2)}{\\alpha&HFF}{\\iclip($XUP2,$YUP1,$XUP2,$YUP2)}";
		$Upperfirst = "{\\4c&H9A35FF}{\\shad3}{\\1c&H$color2}{\\move($UpperXoffset[$i],$UpperYoffset,$UpperXoffset[$i],$Yupperdown,$start[$i],$tdown1)}{\\iclip($Xupper1,$YupperUP1,$Xupper2,$YUP1)}";
		$Upperfirst .= "{\\t($tclipstart,$tclipend,1,\\iclip($Xupper2,$YupperUP1,$Xupper2,$YUP1)}{\\t($tdown1,$tdown1,1,\\alpha&HFF)}";
		$Upper = "{\\move($UpperXoffset[$i],$Yupperdown,$UpperXoffset[$i],$UpperYoffset,$tdown1,$tdown2)}{\\alpha&HFF}{\\iclip($Xupper2,$YupperUP1,$Xupper2,$YUP1)}";
	}
	else{
		//$s = "{\\pos($Xoffset[$i],$Yoffset)}";
		$s = "{\\pos($Xoffset[$i],$Yoffset)}{\\iclip($XUP1,$YUP1,$XUP2,$YUP2)}";
		$s .= "{\\t($tclipstart,$tclipend,1,\\iclip($XUP2,$YUP1,$XUP2,$YUP2)}";
		$Upper = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\iclip($Xupper1,$YupperUP1,$Xupper2,$YUP1)}";
		$Upper .= "{\\t($tclipstart,$tclipend,1,\\iclip($Xupper2,$YupperUP1,$Xupper2,$YUP1)}";
	}
	
	
//================================================= [ Part C ] ====================================================
//�а���̵��Ū�������� ( $s�ٸ�������, $Upper�پ������� )
//
//����: 1. ���������������OK�ʵ�ø��ø�С�
//	2. ��λ��������ʬ����Ū���������?�ʰ�����Ū��������������Ƴ�׏����OK�����а�����ˡͭ����Ʊ�� 
//	   �ܻ���{\\K$PreOffset[$i]}{\\K$offset[$i]}��
	
	$accel=8;
	//$range=$accel*$accel/2;//y=-x^4+10
	//$unit=cySub_GetBlockParam($i, BLOCK_WIDTH)/$range;
	$unit=($XUP2-$XUP1)/$accel;
	$unit_upper=($Xupper2-$Xupper1)/$accel;
	$time_range=1000;
	$tunit=$time_range/(($accel+1)*($accel/2));
	$time1=$EventStart;
	$XUPfor=$XUP1;
	$Xupperfor=$Xupper1;
	$s .= "{\\t($tclipstart2,$tclipstart2,1,\\iclip($XUP1,$YUP1,$XUP1,$YUP2)}{\\t($tclipstart2,$tclipend2,1,\\iclip($XUP1,$YUP1,$XUP2,$YUP2)}";
	$Upper .= "{\\t($tclipstart2,$tclipstart2,1,\\iclip($Xupper1,$YupperUP1,$Xupper1,$YUP1)}{\\t($tclipstart2,$tclipend2,1,\\iclip($Xupper1,$YupperUP1,$Xupper2,$YUP1)}";
	/*
	for ( $j=0; $j<$accel; $j++){
		$XUPfor=$XUPfor+$unit;
		$Xupperfor=$Xupperfor+$unit_upper;
		$time2=$time1+$tunit*$j;
		if($BlockText[$i] == 'Chu!'){
			$s .= "{\\t($time1,$time2,1,\\iclip($XUPfor,$YUP1,$XUP2,$YUP2)}";
			$Upper .= "{\\t($time1,$time2,1,\\iclip($Xupperfor,$YupperUP1,$Xupper2,$YUP1)}";
		}
		else{
			$sfirst .= "{\\t($time1,$time2,1,\\iclip($XUPfor,$YUP1,$XUP2,$YUP2)}";
			$Upperfirst .= "{\\t($time1,$time2,1,\\iclip($Xupperfor,$YupperUP1,$Xupper2,$YUP1)}";
		}
		$time1=$time2;
	}
	$time1=$EventEnd-$time_range;
	$XUPfor=$XUP1;
	$Xupperfor=$Xupper1;
	for ( $j=0; $j<$accel; $j++){
		$XUPfor=$XUPfor+$unit;
		$Xupperfor=$Xupperfor+$unit_upper;
		$time2=$time1+$tunit*$j;
		$s .= "{\\t($time1,$time2,1,\\iclip($XUP1,$YUP1,$XUPfor,$YUP2)}";
		$Upper .= "{\\t($time1,$time2,1,\\iclip($Xupper1,$YupperUP1,$Xupperfor,$YUP1)}";
		$time1=$time2;
	}
	*/
	if($BlockText[$i] != 'Chu!'){
		$s .= "{\\fad(0,0)}{\\shad5}{\\4c&H$color4}{\\t($tdown1,$tdown1,1,\\alpha&H00)}{\\t($tdown1,$tdown2,1,\\1c&H$color1}";
		$Upper .= "{\\fad(0,0)}{\\shad5}{\\shad3}{\\t($tdown1,$tdown1,1,\\alpha&H00)}{\\4c&H9A35FF}{\\t($t1,$t2,1,\\4c&H$color4}";
		
	}
	else{
		$s .= "{\\fad(0,0)}{\\shad5}{\\alpha&H00}{\\4c&H9A35FF}{\\1c&H$color2}{\\t($start[$i],$start[$i],1,\\1c&H$color1}";
		$Upper .= "{\\fad(0,0)}{\\shad3}{\\alpha&H00}{\\4c&H9A35FF}{\\1c&H$color2}{\\t($start[$i],$start[$i],1,\\1c&H$color1}";
		
		$accel=8;
		//$range=$accel*$accel/2;//y=-x^4+10
		//$unit=cySub_GetBlockParam($i, BLOCK_WIDTH)/$range;
		$unit_mag=20/$accel;
		$a=mt_rand(0,1);
		if($a==$last){
			$try+=1;
			if($try>=2){
				$try=0;
				$a++;
				$last=$a;
			}
		}
		else{
			$try=0;
			$last=$a;
		}
		$unit_angle=mt_rand(10,15)/$accel;
		$chu_angle=0;
		if($a%2==1) $unit_angle=$unit_angle*-1;
		$time_range=300;
		$tunit=$time_range/(($accel+1)*($accel/2));
		$time1=$start[$i];
		$magni=100;
		for ( $j=0; $j<$accel; $j++){
			$magni=$magni+$unit_mag;
			$chu_angle=$chu_angle+$unit_angle/2;
			$time2=$time1+$tunit*$j;
			$s .= "{\\t($time1,$time2,1,\\fsc$magni\\frz$chu_angle}";
			$Upper .= "{\\t($time1,$time2,1,\\fsc$magni\\frz$chu_angle}";
			$time1=$time2;
		}
		$time1=$start[$i]+1000-300;
		for ( $j=0; $j<$accel; $j++){
			$magni=$magni-$unit_mag;
			$chu_angle=$chu_angle+$unit_angle/2;
			$time2=$time1+$tunit*$j;
			$s .= "{\\t($time1,$time2,1,\\fsc$magni\\frz$chu_angle}";
			$Upper .= "{\\t($time1,$time2,1,\\fsc$magni\\frz$chu_angle}";
			$time1=$time2;
		}
	}

//================================================= [ Part D ] ====================================================
//���������������¸
//
//����: 1. �������ݲ�ǽ��ƶ�������?���ﱿ�����ͭ������¿�ػ������á���������׽�������ϡ�

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
	if($BlockText[$i] != 'Chu!'){
		$sfirst .= "{\\an5}$BlockText[$i]";
		$Upperfirst .= "{\\an5}{\\fs$SmallFrontSize}$upper[$i]";

		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $sfirst;
		$objNewEvent -> layer = 1;
		$objNewEvent -> save();

		
		if( $UpperStyle[$i] >= 0 )
		{
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $Upperfirst;
			$objNewEvent -> layer = 0;
			$objNewEvent -> save();
		}
		
	}

//================================================= [ Part E ] ====================================================
//��Ԧ����
//
//����: 1. �ʲ����������������㡤�����򼹹ԡ�
//	2. ǡ�߼��԰ʲ���������?��������ƬŪ "//" �ܽ���
//
	
	if( $BlockText[$i] == 'Chu!'){
		$size[0]=mt_rand(270,300); $size[1]=mt_rand(250,270); $size[2]=mt_rand(150,200); $size[3]=mt_rand(150,180); $size[4]=mt_rand(120,140);
		$angle[0]=mt_rand(25,35); $angle[1]=mt_rand(-35,-25); $angle[2]=mt_rand(20,30); $angle[3]=mt_rand(-10,-6); $angle[4]= mt_rand(6,14);
		$AdjXoffset[0]=$Xoffset[$i]-100; $AdjXoffset[1]=$Xoffset[$i]+90;
		$AdjXoffset[2]=$Xoffset[$i]-80;  $AdjXoffset[3]=$Xoffset[$i];
		$AdjXoffset[4]=$Xoffset[$i];
		$AdjYoffset[0] = $Yoffset-30; $AdjYoffset[1] = $Yoffset +17;
		$AdjYoffset[2] = $Yoffset+30; $AdjYoffset[3] = $Yoffset-30;
		$AdjYoffset[4] = $Yoffset+30;
		$heart_tmid=$start[$i]+100;
		$heart_tend=$heart_tmid+500;
		$heart_color[0]='8000FF'; $heart_color[1]='7800F0'; $heart_color[2]='9A35FF'; $heart_color[3]='E0C1FF';
		if($heart_tend > $EventEnd) $heart_tend=$EventEnd;
		$get=mt_rand(0,2);
		$hcolor=$heart_color[$get];
		for($k=0; $k<20; $k++){
			$a=mt_rand(0,4);
			$b=mt_rand(0,4);
			$temp=$size[$a];
			$size[$a]=$size[$b];
			$size[$b]=$temp;
		}
		for($k=0; $k<5; $k++){
			$AdjXoffset2[$k]=$AdjXoffset[$k]+mt_rand(-20,20);
			$AdjYoffset2[$k]=$AdjYoffset[$k]-mt_rand(20,30);
		}

		for($k=0; $k<5; $k++){
			$heart[$k] = "{\\an5}{\\1c&H$hcolor&}{\\move($AdjXoffset[$k],$AdjYoffset[$k],$AdjXoffset2[$k],$AdjYoffset2[$k],$heart_tmid, $EventEnd)}{\\frz$angle[$k]}{\\fsc0}{\\bord0}{\\blur3}{\\shad0}{\\alpha&HFF}}{\\be1}";
			$heart[$k] .= "{\\fad(300,$time_range)}{\\t($start[$i],$heart_tmid,1,\\alpha&H00\\fsc$size[$k])}{\\t($heart_tmid,$heart_tend,1,\\alpha&H40\\fsc$size[$k])}";
			$heart[$k] .= "{\\p1}m 16 30 b 28 22 30 18 30 14 b 32 8 22 -2 16 10 b 10 -2 0 8 2 14 b 2 18 4 22 16 30{\\p0}";
			
			$objNewEvent = new SSADialogEvent;
			$objNewEvent -> text = $heart[$k];
			$objNewEvent -> layer = 4;
			$objNewEvent -> save();
		}
	}
	
//
//================================================================================================== by ���� ======

$tclipstart=$tclipend;
$tclipstart2=$tclipend2;
}
?> 