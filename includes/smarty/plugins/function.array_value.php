<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_table} function plugin
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_array_value($params, &$smarty)
{
	$keys = array();
	$assoc= array();
	$result = array();

    foreach ($params as $_key=>$_value) {
                $$_key =  $_value ;
    }

	$keys = (array)$keys;
	$assoc = (array)$assoc;

	if(empty($keys) or empty($assoc))  return "";

	foreach($keys as $key=>$val)
	{
		if(isset($assoc[$val])) $result[] = $assoc[$val];
	}

	return implode($separator, $result);

}
?>
