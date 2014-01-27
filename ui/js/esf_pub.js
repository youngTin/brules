//$(document).ready(function(){
//	var esf_type=$('#type').val();
//	if(esf_type==1)
//	{
//		//check_esf_tp1(); 	//\u51FA\u79DF
//	}
//	else if(esf_type==2)
//	{
//		check_esf_tp2();	 //\u51FA\u552E
//	}
//});
/*
 *	function check_esf_tp1 
 * 	\u4E8C\u624B\u623F\u51FA\u552E\u53D1\u5E03\u5904\u7406
 */
function check_esf_tp2()
{
	var $reside = getid('reside'); //\u5C0F\u533A\u540D\u79F0
	var $address = getid('address'); //\u623F\u6E90\u5730\u5740
	var $borough1 = getid('borough1'); //\u884C\u653F\u533A
	var $direction = getid('direction'); //\u6240\u5C5E\u65B9\u4F4D
	var $total_area = getid('total_area'); //\u4EA7\u6743\u9762\u79EF
	var $room = getid('room'); //\u5385
	var $parlor = getid('parlor'); //\u5BA4
	var $toilet = getid('toilet'); //\u536B
	var $price = getid('price');//\u79DF\u91D1
	var $current_floor = getid('current_floor'); //\u7B2C\u51E0\u697C\u5C42
	var $total_floor = getid('total_floor');//\u5171\u51E0\u697C\u5C42
	var $build_year = getid('build_year'); //\u623F\u9F84
	var $lease_0 = getid('lease_0');//\u4E0D\u5E26\u79DF\u7EA6
	var $lease_1 = getid('lease_1'); //\u5E26\u79DF\u7EA6
	var $title = getid('title');//\u623F\u6E90\u6807\u9898
	var $description = getid('description');//\u623F\u6E90\u63CF\u8FF0
	if($.trim($reside)=='' || $.trim($reside)=='\u8BF7\u8F93\u5165\u5C0F\u533A\u540D\u79F0\uFF0C\u5982\uFF1A\u9526\u4E0A\u82B1')
	{
		alert('\u8BF7\u8F93\u5165\u5C0F\u533A\u540D\u79F0!');
		$('#reside').focus();
		return false;
	}
	if($.trim($address)=='')
	{
		alert('\u8BF7\u8F93\u5165\u623F\u6E90\u5730\u5740!');
		$('#address').focus();
		return false;
	}
	if($address.length<1||$address.length>60)
	{
		alert('\u623F\u6E90\u5730\u5740\u957F\u5EA6\u5FC5\u9700\u57281\u523060\u4E2A\u5B57\u4E4B\u95F4!');
		$('#address').focus();
		return false;
	}
	if(!$borough1)
	{
		alert('\u8BF7\u9009\u62E9\u884C\u653F\u533A\u57DF!');
		$('#borough1').focus();
		return false;
	}
	/*if(!$direction)
	{
		alert('\u8BF7\u9009\u62E9\u6240\u5C5E\u65B9\u4F4D!');
			$('#direction').focus();
		return false;
	}*/
	if($.trim($total_area)=='' || isNaN($total_area) || !$total_area)
	{
		alert('\u8BF7\u586B\u5199\u4EA7\u6743\u9762\u79EF!');
		$('#total_area').focus();
		return false;
	}
	if($.trim($price)=='' || isNaN($price))
	{
		alert('\u8BF7\u586B\u5199\u552E\u4EF7!');
		$('#price').focus();
		return false;
	}
	if(parseInt($price)>10000)
	{
		alert('\u552E\u4EF7\u4E0D\u53EF\u4EE5\u5927\u4E8E10000 \u4E07!');
		$('#price').focus();
		return false;
	}
	if($.trim($current_floor)=='' || isNaN($current_floor))
	{
		alert('\u8BF7\u586B\u5199\u6240\u5728\u697C\u5C42!');
		$('#current_floor').focus();
		return false;
	}
	if($.trim($total_floor)=='' || isNaN($total_floor))
	{
		alert('\u8BF7\u586B\u5199\u603B\u5171\u697C\u5C42!');
		$('#total_floor').focus();
		return false;
	}
		if(parseInt($current_floor) > parseInt($total_floor))
	{
		alert('\u6240\u5728\u697C\u5C42\u4E0D\u80FD\u5927\u4E8E\u603B\u697C\u5C42!');
		$('#total_floor').focus();
		return false;
	}
	if($build_year=='' || isNaN($build_year))
	{
		alert('\u8BF7\u586B\u5199\u623F\u9F84!');
		$('#build_year').focus();
		return false;
	}
	if(parseInt($build_year)>100)
	{
		alert('\u623F\u9F84\u4E0D\u80FD\u5927\u4E8E100\u5E74!');
		$('#build_year').focus();
		return false;
	}
	if($.trim($title)=='' || $title.length<1 || $title.length>40 || $title=='\u4E00\u4E2A\u597D\u7684\u6807\u9898\u662F\u5438\u5F15\u773C\u7403\u7684\u7B2C\u4E00\u6B65')
	{
		alert('\u623F\u6E90\u6807\u9898\u957F\u5EA6\u9519\u8BEF!');
		$('#title').focus();
		return false;
	}
/*	if($.trim($description)=='' || $description.length<1 || $description.length>200)
	{
		alert('\u8BF7\u586B\u5199\u623F\u6E90\u63CF\u8FF0!');
		$('#description').focus();
		return false;
	}*/
	return true;
}
/*
 * function check_esf_tp2()
 * \u4E8C\u624B\u623F\u51FA\u79DF\u53D1\u5E03\u5904\u7406
 */
function check_esf_tp1()
{
	var $reside = getid('reside'); //\u5C0F\u533A\u540D\u79F0
	var $address = getid('address'); //\u623F\u6E90\u5730\u5740
	var $borough1 = getid('borough1'); //\u884C\u653F\u533A
	var $direction = getid('direction'); //\u6240\u5C5E\u65B9\u4F4D
	var $total_area = getid('total_area'); //\u4EA7\u6743\u9762\u79EF
	var $build_year = getid('build_year'); //\u623F\u9F84
	var $room = getid('room'); //\u5385
	var $parlor = getid('parlor'); //\u5BA4
	var $toilet = getid('toilet'); //\u536B
	var $price = getid('price');//\u79DF\u91D1
	var $current_floor = getid('current_floor'); //\u7B2C\u51E0\u697C\u5C42
	var $total_floor = getid('total_floor');//\u5171\u51E0\u697C\u5C42
	var $build_year = getid('build_year'); //\u623F\u9F84
	var $lease_0 = getid('lease_0');//\u4E0D\u5E26\u79DF\u7EA6
	var $lease_1 = getid('lease_1'); //\u5E26\u79DF\u7EA6
	var $title = getid('title');//\u623F\u6E90\u6807\u9898
	var $description = getid('description');//\u623F\u6E90\u63CF\u8FF0
	var $fitment = getid('fitment');//\u88C5\u4FEE\u7A0B\u5EA6
	if($.trim($reside)=='' || $.trim($reside)=='\u8BF7\u8F93\u5165\u5C0F\u533A\u540D\u79F0\uFF0C\u5982\uFF1A\u9526\u4E0A\u82B1')
	{
		alert('\u8BF7\u8F93\u5165\u5C0F\u533A\u540D\u79F0!');
		$('#reside').focus();
		return false;
	}
	if($.trim($address)=='')
	{
		alert('\u8BF7\u8F93\u5165\u623F\u6E90\u5730\u5740!');
		$('#address').focus();
		return false;
	}
	if($address.length<1||$address.length>60)
	{
		alert('\u623F\u6E90\u5730\u5740\u957F\u5EA6\u5FC5\u9700\u57281\u523060\u4E2A\u5B57\u4E4B\u95F4!');
		$('#address').focus();
		return false;
	}
	if(!$borough1)
	{
		alert('\u8BF7\u9009\u62E9\u884C\u653F\u533A\u57DF!');
		$('#borough1').focus();
		return false;
	}
	if(!$parlor)
	{
		alert('\u8BF7\u9009\u62E9\u6237\u578B!');
		$('#borough1').focus();
		return false;
	}
	if($.trim($current_floor)=='' || isNaN($current_floor))
	{
		alert('\u8BF7\u586B\u5199\u6240\u5728\u697C\u5C42!');
		$('#current_floor').focus();
		return false;
	}
	if($.trim($total_floor)=='' || isNaN($total_floor))
	{
		alert('\u8BF7\u586B\u5199\u603B\u5171\u697C\u5C42!');
		$('#total_floor').focus();
		return false;
	}
	if(parseInt($current_floor) > parseInt($total_floor))
	{
		alert('\u6240\u5728\u697C\u5C42\u4E0D\u80FD\u5927\u4E8E\u603B\u697C\u5C42!');
		$('#total_floor').focus();
		return false;
	}
	if($.trim($price)=='' || isNaN($price))
	{
		alert('\u8BF7\u586B\u5199\u79DF\u91D1!');
		$('#price').focus();
		return false;
	}
		if($build_year=='' || isNaN($build_year))
	{
		alert('\u8BF7\u586B\u5199\u623F\u9F84!');
		$('#build_year').focus();
		return false;
	}
	/*if(!$("#fitment:checked").val())
	{
		alert('\u8BF7\u9009\u62E9\u88C5\u4FEE\u7A0B\u5EA6!');
		$('#fitment').focus();
		return false;
	}
	if(!$("#facilities:checked").val())
	{
		alert('\u8BF7\u9009\u62E9\u914D\u5957\u8BBE\u65BD!');
		$('#facilities').focus();
		return false;
	}*/

	if(parseInt($build_year)>100)
	{
		alert('\u623F\u9F84\u4E0D\u80FD\u5927\u4E8E100\u5E74!');
		$('#build_year').focus();
		return false;
	}
		if($.trim($title)=='' || $title.length<1 || $title.length>40 || $title=='\u4E00\u4E2A\u597D\u7684\u6807\u9898\u662F\u5438\u5F15\u773C\u7403\u7684\u7B2C\u4E00\u6B65')
	{
		alert('\u623F\u6E90\u6807\u9898\u957F\u5EA6\u9519\u8BEF!');
		$('#title').focus();
		return false;
	}
/*	if($.trim($description)=='' || $description.length<1 || $description.length>200)
	{
		alert('\u8BF7\u586B\u5199\u623F\u6E90\u63CF\u8FF0!');
		$('#description').focus();
		return false;
	}*/
	return true;
}
function getid(id)
{
	return $('#'+id).val();
	
}
//\u8868\u5355\u957F\u5EA6\u63D0\u793A\u9A8C\u8BC1
//id DOM id
//lens \u957F\u5EA6
function titlelens(id,lens)
	{
		//\u5B57\u6570\u63D0\u793A
	$("#"+id['id']).keydown(function()
	{
		if($("#"+id['id']).val().length>0 &&  $("#"+id['id']).val().length < lens+1)
		{
			$("#_"+id['id']).html("(\u6B64\u5904\u53EF\u5199<b>"+lens+"</b>\u4E2A\u5B57,\u4F60\u8FD8\u53EF\u4EE5\u5199<b>"+(lens-$("#"+id['id']).val().length)+"</b>\u4E2A\u5B57!)");
		}
		});
	}
	
function limitChars(id, count){  
    var obj = document.getElementById(id);  
    if (obj.value.length > count){  
			alert('\u5B57\u6570\u592A\u957F,\u4F60\u6700\u591A\u53EF\u4EE5\u8F93\u5165:'+count+'\u4E2A\u5B57!');
        obj.value = obj.value.substr(0, count);  
    }  
} 