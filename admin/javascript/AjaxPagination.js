var AjaxPageController=function(objname,Param){
	 this.gotourl = function(page)
	 {
		this.pagination(page,'go');
		this.doAjax();
	 }
	 //get方式获取数据
	 this.doAjax = function(){
								 $.getJSON(Param.GetDataUrl,Param,eval(Param.BandingName));
											//$.ajax({
												 //type: "GET",
												 //url: Param.GetDataUrl,
												 //dataType:"json",
												// success:eval(Param.BandingName)
												//});
								 eval(objname).pagination(Param.CurrentPage,"go");
							 }
	 //构造函数,首先声明类和在添加完新纪录时调用,通过get方式获取记录总数,从而更新页面信息和分页导航条的信息
	 this.AjaxPageController = function(){
		//$('#'+objname).css('display','');//数据没加载前，显示等待信息
		if(Param.GetCountUrl!=''){
			$.get(Param.GetCountUrl,Param,function(data){
				Param.RecordCount = data;
				eval(objname).pagination(1,'go');
				eval(objname).doAjax();
			});
		}else{
			eval(objname).doAjax();
		}
	 }
     this.pagination = function(CurrentPage,run)
	 {
	 	var RecordCount = Param.RecordCount;//总记录条数
		//计算出总页数PageCount
		var PageCount = parseInt(Param.RecordCount/Param.PageSize);
		var PageCountMole = Param.RecordCount%Param.PageSize;
		if(PageCountMole>0)PageCount = parseInt(PageCount)+1;
		var showParam = Param.showParam;//设计显示的页数
		if(isNaN(CurrentPage))CurrentPage=1;
		CurrentPage = parseInt(CurrentPage);
		CurrentPage = Math.abs(CurrentPage);
		if(CurrentPage>PageCount)CurrentPage=1;
		//计算出滑动参数sleekParam
		var sleekParam = parseInt(showParam/2);
		var sleekMole = showParam%2;
		if(sleekMole>0)sleekParam = parseInt(sleekParam)+1;
		//生成显示方法show调用的三个参数，分别记录了分页信息
		var arrayPageInfo = new Array();//分页页码编号
		var prePage = 0;//该数字记录上一页信息页码，0代表不存在
		var nextPage = 0;//该数字记录下一页信息，0代表不存在
		if(PageCount>0){
			//如果当前页大于等于2时，将出现"<<"上一页标记
			if(CurrentPage>=2){prePage = parseInt(CurrentPage)-1;}
			//判断总页数是否大于设计显示页数
			if(PageCount<showParam){
				var ProShowNum=PageCount;
				for(var i=1;i<=ProShowNum;i++){
					//返回导航页码信息
					arrayPageInfo[i] = new Array();
					arrayPageInfo[i][0] = i;
					arrayPageInfo[i][1] = objname+".gotourl("+i+")";}
			}else{
				var ProShowNum=showParam;
				if(CurrentPage<=sleekParam){
					for(var i=1;i<=showParam;i++){
					//返回导航页码信息
					arrayPageInfo[i] = new Array();
					arrayPageInfo[i][0] = i;
					arrayPageInfo[i][1] = objname+".gotourl("+i+")";
					}
				}else{
					var isLastThree = parseInt(CurrentPage)+parseInt(sleekParam);
					if(isLastThree>PageCount){var startPage = (parseInt(PageCount)-parseInt(showParam))+1;
						var endPage = parseInt(PageCount);
					}else{var midvar = parseInt(sleekParam)-1;
						var startPage = parseInt(CurrentPage)-midvar;
						var endPage = parseInt(CurrentPage)+midvar;
					}
					var j=1;
					for(var i=startPage;i<=endPage;i++){
						//返回导航页码信息
						//alert(j);
						arrayPageInfo[j] = new Array();
						arrayPageInfo[j][0] = i;
						arrayPageInfo[j][1] = objname+".gotourl("+i+")";
						j++;}
				}
			}
			//如果当前页小于总页数时，将出现">>"下一页标记
			if(parseInt(CurrentPage)<parseInt(PageCount)){nextPage = parseInt(CurrentPage)+1;}
			//***showString = showString+"</span></td><td>&nbsp;跳转到:&nbsp;<input type='text' id='goPage' name='goPage' style='width:20px;text-align:center'>&nbsp;<input type='button' value='GO' style='width:20px' onclick='bridge("+PageCount+","+showParam+","+sleekParam+")' /></td></tr></table>";
		}
		Param.CurrentPage = CurrentPage;
		//下面代码用来控制分页信息的显示
		var waiting_flag;
		if(run !='go') {waiting_flag=" onclick='return false;'"}else{waiting_flag=""};
		var stringHtml = "";
		$("#"+objname+"_RecordCount").html(RecordCount.toString());
		$("#"+objname+"_CurrentPage").html(CurrentPage.toString());
		$("#"+objname+"_PageCount").html(PageCount.toString());
		//判断是否会出现上一页"<<"标签
		if(prePage!=0){
			$("#"+objname+"_PrePage").html("<a onclick='javascript:"+objname+".gotourl("+prePage+")'"+waiting_flag+">上一页</a>");
		}else{$("#"+objname+"_PrePage").html("<a onclick='javascript:void()'>上一页</a>");}
		for(var i in arrayPageInfo)
		{
			if(arrayPageInfo[i][0]==CurrentPage){
				stringHtml = stringHtml+"<B>"+arrayPageInfo[i][0]+"</B>";
			}else{
				stringHtml = stringHtml+"<a href='javascript:"+arrayPageInfo[i][1]+"'"+waiting_flag+" class='item'>"+arrayPageInfo[i][0]+"</a>";
			}
		}
		if(stringHtml!="")$("#"+objname+"_PageRank").html(stringHtml);
		//判断是否会出现下一页">>"标签
		if(nextPage!=0){
			$("#"+objname+"_NextPage").html("<a onclick='javascript:"+objname+".gotourl("+nextPage+")'"+waiting_flag+">下一页</a>");
		}else{$("#"+objname+"_NextPage").html("<a onclick='javascript:void()'>下一页</a>");}
		//返回首页和最后一页
		if(CurrentPage!=1){
			if($("#"+objname+"_FirstPage >a").text()==''){var msg_2 = $("#"+objname+"_FirstPage >B").text();}else{var msg_2 = $("#"+objname+"_FirstPage >a").text();}
			$("#"+objname+"_FirstPage").html("<a href='javascript:"+objname+".gotourl(1);'"+waiting_flag+">"+msg_2+"</a>");
		}else{
			if($("#"+objname+"_FirstPage >a").text()==''){var msg_1 = $("#"+objname+"_FirstPage >B").text();}else{var msg_1 = $("#"+objname+"_FirstPage >a").text();}
			$("#"+objname+"_FirstPage").html("<B>"+msg_1+"</B>");
		}
		if(CurrentPage!=PageCount){
			if($("#"+objname+"_LastPage >a").text()==''){var msg_L2 = $("#"+objname+"_LastPage >B").text();}else{var msg_L2 = $("#"+objname+"_LastPage >a").text();}
			$("#"+objname+"_LastPage").html("<a href='javascript:"+objname+".gotourl("+PageCount+");'"+waiting_flag+">"+msg_L2+"</a>");
		}else{
			if($("#"+objname+"_LastPage >a").text()==''){var msg_L1 = $("#"+objname+"_LastPage >B").text();}else{var msg_L1 = $("#"+objname+"_LastPage >a").text();}
			$("#"+objname+"_LastPage").html("<B>"+msg_L1+"</B>");
		}
		//跳转到某一页
		$("#"+objname+"_RuntoPage").attr("onclick",objname+".gotourl($(\"#"+objname+"_InputPage\").val());");
	 }
};

//get方式获取数据
//function AjaxGetDataParam(){$.getJSON(Param.GetDataUrl,Param,eval(Param.BandingName));}
//get方式获取记录总数
/*
function getCount(){
	$.get(Param.GetCountUrl,Param,function(data){
		Param.RecordCount = data;
		eval(page_Param.objname).doAjax=AjaxGetDataParam;
		eval(page_Param.objname).objectJsParam=Param;
		eval(page_Param.objname).pagination(1);
		AjaxGetDataParam();
	});
}
*/
