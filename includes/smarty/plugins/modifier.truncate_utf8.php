<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty truncate_utf8 modifier plugin
 *
 * Type:     modifier<br>
 * Name:     truncate_utf8<br>
 * Purpose:  ��ȡutf8��ʽ���ַ���, һ���ַ����ɶ���ֽ����ʱ���������ı��������ᱻ�ض�
 * @author   ����־
 * @create 2008-01-22 19:17
 * @param string
 * @param length
 * @param etc �����ֽض��ַ�������������油���ַ���
 * @param LenthOfWchar ���ֽ��ַ��� LenthOfWchar ���㣬��һ�������������ַ�
 * @return string
 */
function smarty_modifier_truncate_utf8($str, $length = 80, $etc = '...', $LenthOfWchar = 2)
{
	$len = strlen($str);
	$r = array();
	$n = 0;
	$i = 0;
	while($i < $len and $n < $length) {
		$x = $str{$i};
		$a = ord($x); //echo '['.base_convert("$a",10,16).']';

		if (($a & 0xE0) == 0xE0) {
			$r[] = substr($str, $i, 3);
			$i += 3;
			$n += $LenthOfWchar;
		} elseif (($a & 0xC0) == 0xC0) {
			$r[] = substr($str, $i, 2);
			$i += 2;
			$n += $LenthOfWchar;
		} elseif ( ($a & 0x80) != 0x80) {
			$r[] = $x;
			$i++;
			$n ++;
		} else {
			$i++;
		}
	}
	if ($i == $len) {
		$etc = '';
	}
	return join('', $r).$etc;
}

?>
