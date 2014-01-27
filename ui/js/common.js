var use_debug = false;
function debug(){
    if( use_debug && window.console && window.console.log ) console.log(arguments);
}
$(function(){
    $(".header-menu li").hover(function(){
        if($(this).attr('class')!='cur')$(this).addClass('cur').attr('data','1');
    },function(){
        if($(this).attr('data')=='1') $(this).removeClass('cur');
    })
    $(".menu-box h4").toggle(function(){
        $(this).parent('.menu-box').find('.menu-list').hide();
    },function(){
        $(this).parent('.menu-box').find('.menu-list').show();
    })
    
//    $(".marquee").marquee({
//            loop: -1
            // this callback runs when the marquee is initialized
//            , init: function ($marquee, options){
//                debug("init", arguments);

                // shows how we can change the options at runtime
//                options.yScroll = "bottom";
//            }
            // this callback runs when a has fully scrolled into view (from either top or bottom)
//            , show: function (){
//                debug("show", arguments);
//            }
//    });
    
})
var heights;
$(window).load(function(){
    $("#content-box").css('width',$('body').width()-$("#left-menu").width()-50);
    $("#j-rollingnews").marquee({yScroll: "bottom"});
    var obj = $("#dmarq .dmarquee");
    obj.parent().append(obj.eq(0).clone());
    var dmlen = obj.size(),i=1;
    obj = $("#dmarq .dmarquee");
    heights=108;
    setInterval(function(){   
        var h = i*heights;
        obj.animate({'top':"-"+h},600);
        if(i%dmlen==0){
            setTimeout(function(){obj.css({'top':'0px'});},700)
        } 
        i = (i%dmlen)==0 ? 1 : ++i;
    },7000)
   
})
$(window).resize(function(){
    $("#content-box").css('width',$('body').width()-$("#left-menu").width()-50);
})

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

