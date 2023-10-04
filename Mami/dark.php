<?

//= [CONFIG] ======================================================================================================

define ('TIME_OFFSET_DELAY', 0);	// �]�w�϶�����ɶ� (���: �@��)
define ('SCALE', 1.05);			// �]�w�϶����j	(��ĳ�ƭ�: 0.98)
define ('UPPER_HEIGHT', 0.90);		// �]�w�p�r����	(��ĳ�ƭ�: 0.90)

//= [INIT] ========================================================================================================

if (!function_exists('mb_substr')) 
	include CYSUB_SCRIPT_DIR."function\mb_substr.php";

include CYSUB_SCRIPT_DIR."common_1.4.0.php";
include CYSUB_SCRIPT_DIR."function\upper.php";

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

	$t1 = $start[$i] + $offset[$i] * -5;	
	$t2 = $start[$i] + $offset[$i] * 3;
	$t3 = $start[$i] + $offset[$i] * 5;
	$t4 = $start[$i] + $offset[$i] * 8;
	$t5 = $start[$i] + $offset[$i] * 15;
	$t7 = $EventEnd - 300;
	$t8 = $t7 - 70;//�h��
	$t9 = $t8-100;
	$t10 = $t9 - 100;
	$t11 = $t10 - 200;
	$trans = $t11 -150;
	$trans2 = $end[$i] +300;
	$rotate = mt_rand(-10, 10);
//================================================= [ Part B ] ====================================================
//�P��m�������S�ĥN�X ( $s����y�S��, $Upper���p�r�S�� )
//
//�`�N: 1. \move �P \pos ����P�ɨϥΡA�ϥ� \move �ɻݲ����쥻 \pos ���N�X�C
//	2. �ɶq���n�ϥ� \an�A�Y�n�ϥνбN Part D �N�X���� \an5 �����A����m����W���i��|�������C
//	3. �H�U���N�X�O�@�w��ΡA�Y���Q����L��m�S�ġA�ЫO�d�o���N�X�C

	$s = "{\\pos($Xoffset[$i],$Yoffset)}{\\K$PreOffset[$i]}{\\K$offset[$i]}";
	$Upper = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\K$PreUpperOffset[$i]}{\\K$UpperOffset[$i]}";
	/*
	$sDark = "{\\pos($Xoffset[$i],$Yoffset)}{\\alpha&HFF, \\1cH&000000}";
	$UpperDark = "{\\pos($UpperXoffset[$i],$UpperYoffset)}{\\alpha&HFF, \\1cH&000000}";
	*/

//================================================= [ Part C ] ===================================================={\\t($end[$i],$trans,1, \\alpha&H88, \\1cH&000000)}
//�P��m�L�����S�ĥN�X ( $s����y�S��, $Upper���p�r�S�� )
//
//�`�N: 1. �w�]�S�ĬO�d��OK�H�βH�J�H�X�C
//	2. ���F��K�j�����S�Ī��s�@�A���S���ɥH�@�r�@�檺�覡�s�g�A�]���ɭP�d��OK�S�ĻP�@��g�k���Ǥ��P�A 
//	   ���ϥ�{\\K$PreOffset[$i]}{\\K$offset[$i]}�C
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
//�ƥ�ѼƳ]�w���x�s
//
//�`�N: 1. ��惡�B�i��|�v�T���S���ɥ��`�B�@�A�Y�S���n�s�@�h�h�r���S�ġA�кɶq���n�ק惡�����C

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
//ø�ϫ��O
//
//�`�N: 1. �H�U�N�X�ȴ��Ѽ��g�d�ҡA�ä��|����C
//	2. �p������H�U�N�X�бN�C��N�X�}�Y�� "//" �����C
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
//================================================================================================== by ���� ======
}
?> 