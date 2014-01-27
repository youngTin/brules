<?php
function smarty_modifier_show_thumb($string)
{
	$array = explode(".", $string);
	$string2 = $array[0]."_s.".$array[1];
	if(isset($string2)){$string = $string2;}
	return $string;
}
?>
