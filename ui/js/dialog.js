/***adfloat***/
(function($){ 
    $.fn.jFloat = function(o) {
        o = $.extend({
            top:60,  //广告距页面顶部距离
            left:0,//广告左侧距离
            right:0,//广告右侧距离
            width:100,  //广告容器的宽度
            height:360, //广告容器的高度
            minScreenW:300,//出现广告的最小屏幕宽度，当屏幕分辨率小于此，将不出现对联广告
            position:"left", //对联广告的位置left-在左侧出现,right-在右侧出现
            allowClose:true //是否允许关闭 
        }, o || {});
    var h=o.height;
      var showAd=true;
      var fDiv=$(this);
      if(o.minScreenW>=$(window).width()){
          fDiv.hide();
          showAd=false;
       }
       else{
            fDiv.css("display","block")
            var closeHtml='<div align="right" style="padding:2px;z-index:2000;font-size:12px;cursor:pointer;" class="closeFloat"><span style="border:1px solid #000;height:12px;display:block;width:12px;background-color:#FFFFFF;">×</span></div>';
            switch(o.position){
               case "left":
                    if(o.allowClose){
                       fDiv.prepend(closeHtml);
                        $(".closeFloat",fDiv).click(function(){$(this).hide();fDiv.hide();showAd=false;})
                        h+=20;
                     }
                    fDiv.css({position:"absolute",left:o.left+"px",top:o.top+"px",width:o.width+"px",height:h+"px",overflow:"hidden"});
                    break;
               case "right":
                    if(o.allowClose){
                       fDiv.prepend(closeHtml)
                        $(".closeFloat",fDiv).click(function(){$(this).hide();fDiv.hide();showAd=false;})
                        h+=20;
                     }
                    fDiv.css({position:"absolute",left:"auto",right:o.right+"px",top:o.top+"px",width:o.width+"px",height:h+"px",overflow:"hidden"});
                    break;
               case "couplet":
                    if(o.allowClose){
                       fDiv.prepend(closeHtml);
                        $(".closeFloat").live('click',function(){$(this).hide();$(this).parent('div').hide();showAd=false;})
                        h+=20;
                     }
                     var ad2 = "<div id='adhtml2' >"+fDiv.clone().html()+"</div>";fDiv.parent().append(ad2);
                    fDiv.css({position:"absolute",left:o.left+"px",top:o.top+"px",width:o.width+"px",height:h+"px",overflow:"hidden"});
                     $("#adhtml2").css({position:"absolute",left:"auto",right:o.right+"px",top:o.top+"px",width:o.width+"px",height:h+"px",overflow:"hidden"});
                    break;
            };
        };
        var pos = o.position;
        function ylFloat(){
            if(!showAd){return}
            var windowTop=$(window).scrollTop();
            if(fDiv.css("display")!="none")
                fDiv.css("top",o.top+windowTop+"px");
            if(pos == 'couplet')$("#adhtml2").css("top",o.top+windowTop+"px");
        };
      $(window).scroll(ylFloat) ;
      $(document).ready(ylFloat);     
       
    }; 
})(jQuery);

(function(){
    var d = art.dialog.defaults;
    
    // 按需加载要用到的皮肤，数组第一个为默认皮肤
    // 如果只使用默认皮肤，可以不填写skin
    d.skin = [ 'chrome', 'aero','default','facebook'];
    
    // 支持拖动
    d.drag = true;
    
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

//AJAX
function markG(url,id,did)
{
    var itemID = 'itemText';
    if(did != void 0)
    {
        itemID = did ;
    }
    if(url.indexOf(".php") <=0)
    {
        url = 'house_item.php?do='+url;
    }
    var http = url+'&itemid='+itemID+'&sp='+id;
    $.dialog.load(http,{
            title: '提示信息',
            id:itemID
        },true);
    if(did != void 0)
    {
        $.dialog.get('itemText').close() ;
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
    var html = '<link href="/admin/images/admin.css" rel="stylesheet" type="text/css" />';
    
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
