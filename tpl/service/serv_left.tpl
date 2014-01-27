{include file="brules/header.tpl"}
<link href="/ui/js/jQselect/css/index.css" type="text/css" rel="stylesheet" >
<script type="text/javascript" src="/ui/js/jQselect/jQselect.js" ></script>
<style type="text/css">
{literal}
p,h3{margin:0;}
.mgTop10{margin-top:10px;}
.guarLeft,.guarRight{float:left;}

.serv-box{border:solid 1px #D9D8D8;width:220px;}
.serv-box .serv-box-head{color:;background:url('/ui/img/menu_bj.jpg') repeat-x 0 -38px;line-height:44px;height:44px;}
.serv-box .serv-box-head .serv-htitle{color:;background:url('/ui/img/dt_ico1.jpg') no-repeat 180px center;line-height:44px;height:44px;color:#C41414;width:200px;display:inline-block;font-size:16px;margin-left:10px;}
.serv-box .servList{overflow:hidden;}
.serv-box .servList li{line-height:38px;background:url('/ui/img/dt_ico2.jpg') no-repeat 190px center ;}
.serv-box .servList li.act{color:#C41414;background-image:url('/ui/img/dt_ico10.jpg');}
.serv-box .servList li.act a{color:#C41414;}
.serv-box .servList li a{margin-left:20px;font-size:14px;width:100%;display:inline-block;color:#333333;}
.serv-box .servList li a:hover{color:#C41414;}

.guarRight{margin-left:15px;width:760px;}
.srHead{border-bottom:dashed 1px #969696;padding:10px 0;}
.sr-box {margin:20px auto;}
.sr-box .srb-img{width:290px;height:250px;border:1px solid #E8E8E8;text-align:center;display:table-cell;vertical-align: middle;float:left;}
.sr-box .srb-set{width:455px;float:left;margin-left:10px;}
.sr-box .srb-set .srbs-row{width:100%;font-size:14px;color:#6D6D6D;line-height:36px;text-align:bottom;}
.srb-set .srbs-row .srbs-title{float:left;display:inline-block;width:70px;height:36px;}

.srb-set .srbs-row span{display:inline-block;}
.srb-set .srbs-row .srbs-bprice{color:#FF6600;font-size:30px;}
.srbs-row .select{width:76px;line-height:27px;padding:5px;}
.srb-set .srbs-row span ul{overflow:hidden;}
.srb-set .srbs-row span .srbs-list li{float:left;border:2px solid #DBDBDB;line-height:20px;margin-right:4px;font-size:12px;text-align:center;padding:2px 5px;cursor:pointer;}
.srb-set .srbs-row span .srbs-list li.cur{float:left;border:2px solid #C41414;}
.srb-set .srbs-row span .servBtn{background:url('/ui/img/serv-ban.jpg') no-repeat left center;width:147px;height:42px;display:inline-block;text-indent:-99em;cursor:pointer;}

.box_bg{background:url('/ui/img/srv_box.jpg') repeat-x left center ;border:solid 1px  #D6D6D6;line-height:39px;height:39px;width:100%;display:inline-block;}
.box_bg span{left:10px;border-top:solid 1px  #D6D6D6;border-left:solid 1px  #D6D6D6;border-right:solid 1px  #D6D6D6;color:#C41414;font-size:20px;line-height:34px;top:5px;padding:0 10px;float:left;position:relative;background:#FFFFFF;}
{/literal}
</style>
<script type="text/javascript" src="/ui/js/reg_new.js"></script>
<script type="text/javascript">
var type = '{$type}';
{literal}
$(function(){
    var ln = $(".servList li.act").index();
    $(".servList li").hover(function(){
        $(this).addClass("act");
    },function(){
        if($(this).index()!=ln)$(this).removeClass('act');
    })
    
    $("#year").selectbox({func:"howMuch()"});
    $("#month").selectbox({func:"howMuch()"});
    $(".srbs-list li").click(function(){
        var parents = $(this).parent('ul');
        if(parents.attr('onlyOne')=='true')
        {
            parents.find('li').removeClass('cur');
        }
        if($(this).attr('class').indexOf("cur")!=-1&&parents.attr('onlyOne')!='true')$(this).removeClass('cur');
        else $(this).addClass('cur');
        howMuch()
    })
    $("#servSub").click(function(){
        $.dialog.load('/serv/banBox.shtml',{
            title:'请填写相关信息提交订单',
            id:'itemT',
            width:460,
            lock:true
        });
    })
    howMuch()
})
function howMuch()
{
    var listfee = 0 ,baseFee = {/literal}{$info.basicfee}{literal} , yFee = 0 , yDFfee = $("#year").attr('dataFrom') ,yDfee = $("#year").attr('data') ;
    $(".srbs-list li.cur").each(function(){
        listfee += parseFloat($(this).attr('data'));
    })
    var year = $("#year").val();
    var month = $("#month").val();
    //get now 
    var curDate = new Date();
    var curYear = curDate.getFullYear();
    var curMonth = curDate.getMonth();
    
    var y = curYear - parseInt(year);
    var m = curMonth - parseInt(month);
    if(y==0 && m<0){yFee = 0 ;}
    else{
        if(m>0){
            yFee = 12*y+m;
        }
        if(m<0){
            yFee = (12+m)+(y-1)*12
        }
    }
    
    var aveym = parseInt(parseInt(yFee)/parseInt(yDFfee)) * yDfee ;
    aveym = isNaN(aveym) ? 0 : aveym;
    window.aveyms = aveym;
    window.listfees = listfee;
    window.baseFees = baseFee;
    var all = parseFloat(listfee) + parseFloat(baseFee) + parseFloat(aveym);
    $("#prices").html(all);
}

function bookingInfo()
{ 
    checkInput();           
    if(!isCheck)return false;
        
    var name = $("#pname").val() , phone = $("#phone").val() ,cartype = $("#cartype").val(),area = $("#area").val() ,price = $("#prices").html() ,year = $("#year").val() , month = $("#month").val() ;
    var data = '';
    $(".srbs-row").each(function(){
        var title = $(this).find('.srbs-title').html() , type = $(this).attr('types');
        if(type=='no') return ;
        data += title+"@@" ;
        if(type=='date') data += year+'年'+month+'月'+'('+aveyms+')';
        else
        {
            var list = [];
            $(this).find('li.cur').each(function(){
                list.push($(this).html()+'('+$(this).attr('data')+')') ;
            })
            data += list.join(',');
        }
        data += '##';
    })

    $.ajax({
        url:"/serv/save.shtml?action=save&type="+type,
        type:'post',
        dataType:'json',
        data:{name:name,phone:phone,cartype:cartype,area:area,price:price,data:data},
        beforeSend:function(){
             load_dialog();
        },
        success:function(data)
        {
            loading.close();
            if(data.res=='0')
            {
                message(data.msg);
            }
            else{
                message(data.msg,'1');
                $.dialog.get('itemT').close();
            }
        }
    })
}
{/literal}
</script>
<div class="center-box">
    <div class="hd-center mgTop10">
<div class="guarLeft">
            <div class="serv-box">
                <div class="serv-box-head"><a class="serv-htitle">全部服务分类</a></div>
                <ul class="servList">
                {php}
                    global $serv_Types;
                    foreach($serv_Types as $key=>$item)
                    {
                        $act = $_GET['type'] == $key ? "class='act'" : '' ;
                        $li = "<li $act><a href='/serv/".$key.".shtml'>$item</a></li>";
                        echo $li;
                    }
                {/php}
                </ul>
            </div>
            
        </div>