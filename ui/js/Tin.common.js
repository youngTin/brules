(function(){
    var d = art.dialog.defaults;
    
    // 按需加载要用到的皮肤，数组第一个为默认皮肤
    // 如果只使用默认皮肤，可以不填写skin
    d.skin = [ 'chrome', 'aero','default','facebook'];
    
    // 支持拖动
    d.drag = true;
    d.path = '/ui/js/artDialog';
    // 超过此面积大小的对话框使用替身拖动
   // d.showTemp = 100000;  
})()

/***adfloat***/
var loading;
function load_dialog(){
	loading = art.dialog({
					lock:true,
					title:false,
					border: false,
					drag: false,
					esc: false,
					content:'<div style="padding:10px;background:#F6E9D9"><img src="/ui/images/loading.gif"/><span style="text-align:center;font-weight:bold;padding-left:5px">数据加载,请稍候...</span><div>'
				});
}

function message($msg,$issucess)
{
	var icon  = $issucess != void 0 || $issucess == 'succeed' ? "succeed" : "alert";
	art.dialog({
		content: $msg,
        title:"温馨提示",
		icon: icon
	});
}

//AJAX
function markG(url,id,did,pervid)
{
    var itemID = 'itemText';
    if(did != void 0)
    {
        itemID = did ;
    }
    if(url.indexOf(".php") <=0&&url.indexOf(".html") <=0&&url.indexOf(".shtml") <=0)
    {
        url = '/search.html?action='+url;
    }
    var http = url+'&itemid='+itemID+'&sp='+id;
    $.dialog.load(http,{
            title: '提示信息',
            id:itemID
        },true);
	if(pervid != void 0)
    {
        $.dialog.get(pervid).close() ;
    }
	else
	{
		if(did != void 0)
		{
			$.dialog.get('itemText').close() ;
		}
	}
}
function showNeed(obj)
{
    if($(obj).attr('data')!='')
        $.dialog({content:$(obj).attr('data'),skin:'aero',title:'联系要求'});
}
function makeDo($data,$id)
{
    var str = "<p class='showtel'><a class='contact'><b class='f_brownblack'>Tel:</b><span class='f_brown f_blod'>"+$data.info+"</span></a></p><p class='linkneed'><a data='"+$data.linkneed+"' onclick='showNeed(this);'>房东提示》</a></p>"; 
    
    if($data['status']=='1')
    {
        $("#link_"+$id).append(str);
        $("#contact_go_"+$id).parent().remove();
    }
                        
}
//框架
function markGF(url,id)
{
    var http = url;
    $.dialog.open(http,{})
}
//showmsg
function showMsg($mess,$isok,$itemid)
{
    if($mess.length==0)return ;
    var closeItem = 'art.dialog.get("itemids").close();';
    if($itemid != void 0||$item.length==0)closeItem = 'art.dialog.get("'+$itemid+'").close();';
    else $itemid = 'itemids';
    var $ok = 'ok' ;
    if($isok!='1')$ok = 'no';
   var html = '';
    
    html +="<div style='font-size:12px;font-family:verdana;line-height:180%;color:#666;border:dashed 1px #ccc;padding:1px;margin:20px;width:400px;height:300px;'>";
    html +='<div style="background: #eeedea;padding-left:10px;font-weight:bold;height:25px;">提示信息</div>'
    html += '<div style="padding:20px;font-size:14px;">'
    html += '<table>';
    html += '<tr>';
    html += "<td><img width='100px' src='/admin/images/"+$ok+".gif' align='absmiddle' hspace=20 ></td>"
    html += "<td style='width:230px;overflow:hidden;'>"+$mess+"</td>"
    html += "</tr>";
    html += "</table>";
    html += "</div>";
    html += '<div style="text-align:center;height:30px;">';
    html += "<a onclick='"+closeItem+"'>返回继续操作</a>";
    art.dialog({content:html,title:'提示信息',id:$itemid});
}

function showdistricts(container, elems, totallevel, changelevel) {
    var getdid = function(elem) {
        var op = $("#"+elem.selector).find('option:selected');
        return op.attr('did') || '0';
    };
    var pid = changelevel >= 1 && elems[0] && $(elems[0]) ? getdid($(elems[0])) : 0;
    var cid = changelevel >= 2 && elems[1] && $(elems[1]) ? getdid($(elems[1])) : 0;
    var did = changelevel >= 3 && elems[2] && $(elems[2]) ? getdid($(elems[2])) : 0;
    var coid = changelevel >= 4 && elems[3] && $(elems[3]) ? getdid($(elems[3])) : 0;
    var url = "common.php?op=dist2&container="+container
        +"&province="+elems[0]+"&city="+elems[1]+"&district="+elems[2]+"&community="+elems[3]
        +"&pid="+pid + "&cid="+cid+"&did="+did+"&coid="+coid+'&level='+totallevel+'&handlekey='+container+'&inajax=1';
    $.get(url,'',function(data){$("#"+container).html(data)})
}
var isPassVercode = false ;
$(function(){
    $("#s-engno,#s-cno").click(function(){
    $("#show-"+$(this).attr('name')).show();
  }).blur(function(){$("#show-"+$(this).attr('name')).hide();}) ;
  $("#psubBtn").bind("click",function(){
      var lpno = $("#s-lpno").val();
      var cno = $("#s-cno").val();
      var engno = $("#s-engno").val();
      var vpp = /^[A-Za-z0-9]{6}$/;
      var veno = /^[A-Za-z0-9\-]{6}$/;
      if(!vpp.test(lpno)){
          message("请填写正确的车牌号！如川A12345");return false;
      }
      if(!vpp.test(cno)){
          message("请填写正确的车架号！");return false;
      }
      if(!veno.test(engno)){
          message("请填写正确的发动机号！");return false;
      }
      if(!isPassVercode){
          message("请填写正确的验证码！");return false;
      }
      
      markG("/psearch.shtml?action=showTelBox",lpno+"&cno="+cno+"&engno="+engno);
  })
  
  $("#sercTelButton").live('click',function(){
      $("#s-tel").val($("#s-phone").val()); 
      subSearchmit()
  })
  
  $("#s-vercode").blur(function(){
      if($("#s-vercode").val().length!=4){
          //message("验证码错误！");
		  return false;
      }
      $.ajax({
                type:'post',
                dataType:'json',
                url:'member_reg_new.php?action=checkVerCode',
                data:{vercode:$(this).val(),ajax:1},
                timeout:30000,
                beforeSend: function(){
                    $("#loadimg").show();
                },
                success:function(msg){
                    $("#loadimg").hide();
                    if(msg=='1')
                    {
                        isPassVercode = true;
                    }
                    else{
                        isPassVercode = false ;
                        message("验证码错误!");
                        result = false;
                    } 
                }
            });
  })
})

function subSearchmit(isIndex)
{
    try{
        $.dialog.get('itemText').close();
    }catch(e){}
    var lpp = $("#s-lpp").val();
    var lpno = $("#s-lpno").val();
    var cno = $("#s-cno").val();
    var engno = $("#s-engno").val();
    var tel = $("#s-tel").val();
    $.ajax({
        url:"psearch.shtml?action=searchSave",
        dataType:"json",
        type:"post",
        data:{lpp:lpp,lpno:lpno,cno:cno,engno:engno,tel:tel},
        beforeSend: function(){
            load_dialog()
        },
        success:function(msg){
            loading.close();
            if(msg.res=='1')
            {
                message(msg.msg);
            }
            else
            {
				var isIndex = $("#isIndex").val();
				if(isIndex=="1")
				{ 
					window.location.href = '/psearch.shtml?action=search&isIndex=true&id='+msg.id;
				}
				else
				{
					message(msg.msg,'1');
					setTimeout(function(){
					   window.location.href = '/psearch.shtml?action=search&id='+msg.id;
				   },10000) 
				}
               
            }
        }
    })
}