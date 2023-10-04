<?

//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// �]�w�϶�����ɶ� (���: �@��)
define ('SCALE', 0.98);			// �]�w�϶����j	(��ĳ�ƭ�: 0.98)
define ('UPPER_HEIGHT', 0.75);		// �]�w�p�r����	(��ĳ�ƭ�: 0.90)

//= [INIT] ========================================================================================================

if (!function_exists('mb_substr')) 
	include CYSUB_SCRIPT_DIR."function\mb_substr.php";

include CYSUB_SCRIPT_DIR."common_1.4.0.php";
include CYSUB_SCRIPT_DIR."function\upper4.php";

//=============================================== [ Effect Code ] =================================================

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
	$start[$i] -= 30;
	$end[$i] -= 30;
	$dist = 50;
	$k = $objEffectEvent->blockcount - $i;
	$t1 = $start[$i] + $offset[$i] * -5;	
	$t2 = $start[$i] + $offset[$i] * 3;
	$t3 = $start[$i] + $offset[$i] * 5;
	$t4 = $start[$i] + $offset[$i] * 8;
	$t5 = $start[$i] + $offset[$i] * 15;
	$t6 = $EventStart + 60*$i;
	$t7 = $t6 + 200;
	$t8 = $EventEnd - 60*$k;
	$t9 = $t8 - 200;
	$tEnd = $start[$i] + 100;
	if($end[$i] - $start[$i] < 100) $tEnd = $end[$i];
//================================================= [ Part B ] ====================================================
//�P��m�������S�ĥN�X ( $s����y�S��, $Upper���p�r�S�� )
//
//�`�N: 1. \move �P \pos ����P�ɨϥΡA�ϥ� \move �ɻݲ����쥻 \pos ���N�X�C
//	2. �ɶq���n�ϥ� \an�A�Y�n�ϥνбN Part D �N�X���� \an5 �����A����m����W���i��|�������C
//	3. �H�U���N�X�O�@�w��ΡA�Y���Q����L��m�S�ġA�ЫO�d�o���N�X�C
	$Y2 = $Yoffset+$dist;
	
	$UpperY2 = $UpperYoffset + $dist;
	/*
	$sUp = "{\\move($Xoffset[$i],$Yoffset,$Xoffset[$i],$Y2, $start[$i], $end[$i])}";
	$UpperUp = "{\\move($UpperXoffset[$i],$UpperYoffset,$UpperXoffset[$i],$UpperY2, $start[$i], $end[$i])}";
	*/
	$s = "{\\pos($Xoffset[$i],$Yoffset)}";
	$Upper = "{\\pos($UpperXoffset[$i],$UpperYoffset)}";
	

//================================================= [ Part C ] ====================================================
//�P��m�L�����S�ĥN�X ( $s����y�S��, $Upper���p�r�S�� )
//
//�`�N: 1. �w�]�S�ĬO�d��OK�H�βH�J�H�X�C
//	2. ���F��K�j�����S�Ī��s�@�A���S���ɥH�@�r�@�檺�覡�s�g�A�]���ɭP�d��OK�S�ĻP�@��g�k���Ǥ��P�A 
//	   ���ϥ�{\\K$PreOffset[$i]}{\\K$offset[$i]}�C

	/*
	$sUp .= "{\\alpha&HFF}{\\t($t6,$t7,1,\\alpha&H00)}{\\t($t9,$t8,1,\\alpha&HFF)}{\\t($start[$i], $end[$i], 1, \\alpha&HFF)}";
	$UpperUp .= "{\\alpha&HFF}{\\t($t6,$t7,1,\\alpha&H00)}{\\t($t9,$t8,1,\\alpha&HFF)}{\\t($start[$i], $end[$i], 1, \\alpha&HFF)}{\\t($start[$i], $start[$i], 1, \\alpha&HFF)}";
	*/
	$thalf = ($start[$i] + $end[$i])/2;
	$s .= "{\\alpha&HFF}{\\t($t6,$t7,1,\\alpha&H00)}{\\t($t9,$t8,1,\\alpha&HFF)}{\\t($start[$i], $tEnd, 1,\\1vc($color1,$color1,$color2,$color2))}{\\t($start[$i], $thalf, 1, \\bord8, \\3c&HFFFFFF, \\blur7)}{\\t($thalf, $end[$i], 1, \\bord3, \\3c&H$color3, \\blur0)}";
	$Upper .= "{\\alpha&HFF}{\\t($t6,$t7,1,\\alpha&H00)}{\\t($t9,$t8,1,\\alpha&HFF)}{\\t($start[$i], $tEnd, 1,\\1vc($color1,$color1,$color2,$color2))}{\\t($start[$i], $thalf, 1, \\bord8, \\3c&HFFFFFF, \\blur7)}{\\t($thalf, $end[$i], 1, \\bord3, \\3c&H$color3, \\blur0)}";

//================================================= [ Part D ] ====================================================
//�ƥ�ѼƳ]�w���x�s
//
//�`�N: 1. ��惡�B�i��|�v�T���S���ɥ��`�B�@�A�Y�S���n�s�@�h�h�r���S�ġA�кɶq���n�ק惡�����C

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
		$objNewEvent -> layer = 1;
		$objNewEvent -> save();
	}
	/*
	$sUp .= "{\\an5}$BlockText[$i]";
	$UpperUp .= "{\\an5}{\\fs$SmallFrontSize}$upper[$i]";
	
	$objNewEvent = new SSADialogEvent;
	$objNewEvent -> text = $sUp;
	$objNewEvent -> layer = 2;
	$objNewEvent -> save();

	if( $UpperStyle[$i] >= 0 )
	{
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $UpperUp;
		$objNewEvent -> layer = 2;
		$objNewEvent -> save();
	}
	*/
//================================================= [ Part E ] ====================================================
//ø�ϫ��O
//
//�`�N: 1. �H�U�N�X�ȴ��Ѽ��g�d�ҡA�ä��|����C
//	2. �p������H�U�N�X�бN�C��N�X�}�Y�� "//" �����C
//
	/*
	$AdjXoffset[$i] = $Xoffset[$i]-10;
	$AdjYoffset = $Yoffset - 50;
	$Y3 = $AdjYoffset - 2*$dist;
	$tstarmove = $start[$i] + 300;
	$tstarend = $tstarmove + 600;
	$tfade = ($end[$i] - $start[$i])* 0.7 + $start[$i];
	$star = "{\\an5}{\\move($AdjXoffset[$i],$AdjYoffset,$AdjXoffset[$i],$Y3, $start[$i], $end[$i])}{\\bord0}{\\shad1}{\\fscx90\\fscy90}{\\alpha&HFF}}{\\c&H$color2&}{\\be1}";
	$star .= "{\\t($start[$i],$start[$i],1,\\alpha&H00)}{\\t($tfade,$end[$i],1,\\alpha&HFF)}";
	$star .= "{\\p1}m 10 49 l 52 19 0 19 42 49 26 0{\\p0}";
	
	if( $BlockText[$i] != ' ' && $BlockText[$i] != '  ')
	{
		$objNewEvent = new SSADialogEvent;
		$objNewEvent -> text = $star;
		$objNewEvent -> layer = 0;
		$objNewEvent -> save();
	}
	*/
//
//================================================================================================== by ���� ======
}
?> 