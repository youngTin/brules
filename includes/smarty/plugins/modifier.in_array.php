<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty in_array modifier plugin
 *
 * Type:     modifier<br>
 * Name:     in_array<br>
 * Purpose:  phpµÄin_arrayº¯Êı
 * @author   ÂŞ¶«
 * @create 2010-02-18 14:28
 * @param array
 * @param string
 * @return true|false
 */
function smarty_modifier_in_array($str = '', $arr)
{
	return in_array($str, $arr);
}

?>
