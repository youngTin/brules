function alertWin(div_name, close_name, w, h){
	if(div_name=='regist'){
		document.getElementById('login').style.display="none";
		if(document.getElementById('bg'))document.body.removeChild(document.getElementById('bg'));
		document.getElementById('subiframe_r').style.height="260px";
		document.getElementById("subiframe_r").src="/?controller=Front_Default&action=register";
	}
	if(div_name=='modpassword'){
		document.getElementById('personal').style.display="none";
		if(document.getElementById('bg'))document.body.removeChild(document.getElementById('bg'));
		document.getElementById("subiframe_m").src="/?controller=Front_Password&action=ModPassword";
	}
	if(div_name=='findpassword'){
		document.getElementById('login').style.display="none";
		if(document.getElementById('bg'))document.body.removeChild(document.getElementById('bg'));
		document.getElementById('subiframe_f').style.height="235px";
		document.getElementById("subiframe_f").src="/?controller=Front_Password&action=FindPassword";
	}
	if(div_name=='login'){
		document.getElementById('subiframe_l').style.height="242px";
		document.getElementById("subiframe_l").src="/?controller=Front_Default&action=login";
	}
	if(div_name=='loginOut'){
		document.getElementById('personal').style.display="none";
		if(document.getElementById('bg'))document.body.removeChild(document.getElementById('bg'));
		document.getElementById("subiframe_o").src="/?controller=Front_Default&action=logout";
	}
	if(div_name=='collect'){w=w+w;
		document.getElementById("subiframe_c").src="/?controller=Front_Default&action=ShowCollect";
	}
	if(div_name=='personal'){
		document.getElementById('subiframe_p').style.height="250px";
		document.getElementById("subiframe_p").src="/?controller=Front_Default&action=ShowPersonal&name="+close_name;
		close_name = 'close_personal';
	}
	if(document.getElementById("customer_id"))
	document.getElementById("customer_id").style.display = "none";
	var iWidth = document.documentElement.clientWidth; 
	var iHeight = document.documentElement.clientHeight; 
	
	var bgObj = document.createElement("div");
	bgObj.id="bg";
	bgObj.style.cssText = "position:absolute;left:0px;top:0px;width:"+iWidth+"px;height:"+Math.max(document.body.clientHeight, iHeight)+"px;filter:Alpha(Opacity=30);opacity:0.3;background-color:#000000;z-index:101;";
	document.body.appendChild(bgObj); 
	
	var msgObj=document.getElementById(div_name);
	msgObj.style.cssText = "position:absolute;top:"+(iHeight-h-h)/2+"px;left:"+(iWidth-w)/2+"px;width:"+w+"px;height:"+h+"px;text-align:center;padding:1px;line-height:22px;z-index:102;display:none";
	var titleBar = document.getElementById(div_name);
	var moveX = 0;
	var moveY = 0;
	var moveTop = 0;
	var moveLeft = 0;
	var moveable = false;
	var docMouseMoveEvent = document.onmousemove;
	var docMouseUpEvent = document.onmouseup;
	titleBar.onmousedown = function() {
		var all_Obj = document.getElementsByTagName("div");
		for(var i=0;i<all_Obj.length;i++){
			if(parseInt(all_Obj[i].style.zIndex)==1000)all_Obj[i].style.zIndex=102;	
		}
		msgObj.style.zIndex = 1000;
		var evt = getEvent();
		moveable = true; 
		moveX = evt.clientX;
		moveY = evt.clientY;
		moveTop = parseInt(msgObj.style.top);
		moveLeft = parseInt(msgObj.style.left);
		
		document.onmousemove = function() {
			if (moveable) {
				var evt = getEvent();
				var x = moveLeft + evt.clientX - moveX;
				var y = moveTop + evt.clientY - moveY;
				if ( x > 0 &&( x + w < iWidth) && y > 0 && (y + h < iHeight) ) {
					msgObj.style.left = x + "px";
					msgObj.style.top = y + "px";
				}
			}	
		};
		document.onmouseup = function () {  
			if (moveable) { 
				document.onmousemove = docMouseMoveEvent;
				document.onmouseup = docMouseUpEvent;
				moveable = false; 
				moveX = 0;
				moveY = 0;
				moveTop = 0;
				moveLeft = 0;
			} 
		};
	}
	
    // 获得事件Event对象，用于兼容IE和FireFox
    function getEvent() {
	    return window.event || arguments.callee.caller.arguments[0];
    }

	//关闭弹出层
	document.getElementById(close_name).onclick=function (){
		document.getElementById(div_name).style.display="none";
	    if(document.getElementById("customer_id"))
		document.getElementById("customer_id").style.display = "block";
		document.body.removeChild(bgObj);
	}
} 

//登录成功后重新刷新页面
function myrefresh()
{
   window.location.href=window.location.href;
}
