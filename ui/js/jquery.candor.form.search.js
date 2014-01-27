(function($){
    var $c = function(id){return $("#"+id);}
    $.fn.candor = function(options){
        var defaults = {
            TextContent:'输入关键字',
            LabelArr:[],
            ShowBody:'',
            ListToA:'',
            ChangeS:'',
            TextWidth:360,
            isFocus:false
        };
        var options = $.extend(defaults,options);
        var label_arr = options.LabelArr,$text=options.TextContent,STDiv = this.parent() ;
        var isFocus = options.isFocus,obj=this;
        
        $(this).bind('click',function(){
            if($.trim($(this).val())==$text)
            {
                $(this).val('').addClass('on'); 
            }
            listPos(obj);isFocus= true ; 
        }).bind('blur',function(){
             if($.trim($(this).val())=='')
            {
                $(this).val($text).removeClass('on');
            }
            isFocus = false;
        })
        $c(options.ShowBody).bind('click',function(){
            isFocus = true;
        }).bind('blur',function(){
            isFocus = false ;
        })
        
        $c(options.ListToA+" a").bind('click',function(evt){
            var target = getEvt(evt,'dl');
            var onclass = $(this).attr('class');
            var data = $(this).attr('data');
            $c(target+" a").each(function(){
                $(this).removeClass('on');
            })
            if(onclass=='on')
            { 
               $(this).removeClass('on'); $c("s-"+target).remove();textSize();
                return;
            }
            
            $(this).addClass('on');
            
            if(target&&typeof(data)!='undefined')
            {
                if($c("s-"+target).length>0)
                {
                    var str = "<input type='hidden' name='"+label_arr[target]+"' value='"+data+"' />"+$(this).html()+"<span></span>";
                    $c("s-"+target).html(str);
                }
                else
                {
                    var str = "<label id='s-"+target+"'>";
                    str += "<input type='hidden' name='"+label_arr[target]+"' value='"+data+"' />"+$(this).html();
                    str += "<span></span></label>";
                    $c(options.ChangeS).append(str);
                }
                
            }
            textSize();
        })
        $c(options.ChangeS+" label span").live('click',function(evt){
            var target = getEvt(evt,'label'),typeid = target.split('s-');
            $c(target).remove();$c(typeid[1]+" dd a").each(function(){$(this).removeClass('on');})
            textSize();isFocus = true;
        });
        $(".search_b_r").bind('click',function(){ 
            isFocus = isFocus == true ? false : true;
        })
        var getEvt = function(evt,tab){
            var evt = window.event ? window.event: evt,
            target = evt.srcElement || evt.target;       
            while (target.nodeName.toLowerCase() != tab){      
                    target = target.parentNode;  
            } 
            if(target.id!=null&&target!=null)
            {
                return target.id;
            }
        }
        var textSize = function(){
            var s_width = options.TextWidth;
            var c_width = $c(options.ChangeS).width(); 
            STDiv.css('width',(s_width-c_width)+'px');
            
        }
        var listPos = function(obj){
            var _left = obj.parents('div.search_info').offset().left,_top = obj.parents('div.search_info').offset().top,_height = obj.parents('div.search_info').height();
            $c(options.ShowBody).css({'left':_left+3+'px','top':_top+_height-3+'px'});
        }
        
        window.document.onclick = function(evt){
            setTimeout(function(){
                if(isFocus) $c(options.ShowBody).show();
                else $c(options.ShowBody).hide();
            },200)
            
        }
        
    }
})(jQuery)