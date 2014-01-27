// JavaScript Document

ifcheck = true;
function CheckAll(form)
{
	for (var i=0;i<form.elements.length-1;i++)
	{
		var e = form.elements[i];
		if(e.type=='checkbox') e.checked = ifcheck;
	}
	ifcheck = ifcheck == true ? false : true;
}

var selectCheck = 0;
function whole(form)
{
	for (var i=0;i<form.elements.length-2;i++)
	{
		var e = form.elements[i];
		if(e.type=='checkbox'){
			if(e.checked==true) selectCheck++;
		}
	}
	if(selectCheck<=0){
		alert("请选择操作对象");
		return false;
	}
}

function fieldset_open_close(obj){
		if($(obj).attr('class')=='fieldset-close'){
			$(obj).attr('class','fieldset-open');
			$(obj).parent().children('.form-item').css('display','none');
		}else{
			$(obj).attr('class','fieldset-close');
			$(obj).parent().children(".form-item").css('display','');
		}
	}

//鼠标移动table tr行上高亮效果事件
$(document).ready(function(){
	$(".tr3").mouseover(function(){ //如果鼠标移到class为stripe_tb的表格的tr上时，执行函数
	$(this).addClass("over");}).mouseout(function(){ //给这行添加class值为over，并且当鼠标一出该行时执行函数
	$(this).removeClass("over");}) //移除该行的class
	$(".tr3:even").addClass("tr3 t_two"); //给class为stripe_tb的表格的偶数行添加class值为alt
});

/*
//鼠标移动table tr行上高亮效果事件
$(document).ready(function(){
$(".line").mouseover(function(){ //如果鼠标移到class为stripe_tb的表格的tr上时，执行函数
$(this).addClass("over");}).mouseout(function(){ //给这行添加class值为over，并且当鼠标一出该行时执行函数
$(this).removeClass("over");}) //移除该行的class
$("tr:even").addClass("alt"); //给class为stripe_tb的表格的偶数行添加class值为alt
});
*/