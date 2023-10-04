<?

//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// �]�w�϶�����ɶ� (���: �@��)
define ('SCALE', 1.05);			// �]�w�϶����j	(��ĳ�ƭ�: 0.98)
define ('UPPER_HEIGHT', 0.85);		// �]�w�p�r����	(��ĳ�ƭ�: 0.90)
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
//�Ѽƫŧi��
//
//	�r���j�p: $FrontSize			�p�r�j�p: $SmallFrontSize
// 	X�y��: $Xoffset[$i]			�p�rX�y��: $UpperXoffset[$i]	
// 	Y�y��: $Yoffset				�p�rY�y��: $UpperYoffset
//	��y�}�l�ɶ�: $EventStart		��y�����ɶ�: $EventEnd
// 	��r�}�l�ɶ�: $start[$i]		��r�����ɶ�: $end[$i]		��r�g�L�ɶ�: $offset[$i]
// 	�p�r�}�l�ɶ�: $UpperStart[$i]		�p�r�����ɶ�: $UpperEnd[$i]	�p�r�g�L�ɶ�: $UpperOffset[$i]
// 	�D�n��m: $color1	���n��m: $color2	��ئ�m: $color3	�I����m: $color4
//
//�`�N: 1. ���ǰѼƬOArray���A, �᭱���[[$i]�C
//	2. �i�ϥ� mt_rand(a, b) �Ӳ���a, b���üơC
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
//�P��m�������S�ĥN�X ( $s����y�S��, $Upper���p�r�S�� )
//
//�`�N: 1. \move �P \pos ����P�ɨϥΡA�ϥ� \move �ɻݲ����쥻 \pos ���N�X�C
//	2. �ɶq���n�ϥ� \an�A�Y�n�ϥνбN Part D �N�X���� \an5 �����A����m����W���i��|�������C
//	3. �H�U���N�X�O�@�w��ΡA�Y���Q����L��m�S�ġA�ЫO�d�o���N�X�C

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
//�P��m�L�����S�ĥN�X ( $s����y�S��, $Upper���p�r�S�� )
//
//�`�N: 1. �w�]�S�ĬO�d��OK�H�βH�J�H�X�C
//	2. ���F��K�j�����S�Ī��s�@�A���S���ɥH�@�r�@�檺�覡�s�g�A�]���ɭP�d��OK�S�ĻP�@��g�k���Ǥ��P�A 
//	   ���ϥ�{\\K$PreOffset[$i]}{\\K$offset[$i]}�C
	
	$s .= "{\\fad(300,300)}{\\iclip($XUP1,$YUP1,$XUP2,$YUP2)}{\\t($t6,$t7,1,\\iclip($XUP2,$YUP1,$XUP2,$YUP2)}{\\K$PreOffset[$i]}{\\K$offset[$i]}{\\1c&H$color7\\3c&HFFFFFF}";
    $Upper .= "{\\fad(300,300)}{\\iclip($Xupper1,$YupperUP1,$Xupper2,$YUP1)}{\\t($t6,$t7,1,\\iclip($Xupper2,$YupperUP1,$Xupper2,$YUP1)}{\\K$PreUpperOffset[$i]}{\\K$UpperOffset[$i]}{\\1c&H$color7\\3c&HFFFFFF}";	
	//$s2 .= "{\\fad(300,300)}{\\1c&H$color7\\3c&HFFFFFF}";
	//$Upper2 .= "{\\fad(300,300)}{\\1c&H$color7\\3c&HFFFFFF}";

//================================================= [ Part D ] ====================================================
//�ƥ�ѼƳ]�w���x�s
//
//�`�N: 1. ��惡�B�i��|�v�T���S���ɥ��`�B�@�A�Y�S���n�s�@�h�h�r���S�ġA�кɶq���n�ק惡�����C

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
		$objNewEvent = new SSADialogEvent;�u
		$objNewEvent -> text = $Upper2;
		$objNewEvent -> layer = 0;
		$objNewEvent -> save();
	}
	*/
//================================================= [ Part E ] ====================================================
//ø�ϫ��O
//
//�`�N: 1. �H�U�N�X�ȴ��Ѽ��g�d�ҡA�ä��|����C
//	2. �p������H�U�N�X�бN�C��N�X�}�Y�� "//" �����C
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
	

//================================================================================================== by ���� ======
}
?> 