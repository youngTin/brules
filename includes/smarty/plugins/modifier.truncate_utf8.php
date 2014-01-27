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
 * Purpose:  截取utf8格式的字符串, 一个字符的由多个字节组成时，会完整的保留而不会被截断
 * @author   朱彦志
 * @create 2008-01-22 19:17
 * @param string
 * @param length
 * @param etc 若出现截断字符串的情况，后面补充字符串
 * @param LenthOfWchar 多字节字符按 LenthOfWchar 计算，如一个汉字算两个字符
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
