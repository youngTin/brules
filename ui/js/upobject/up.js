function challs_flash_update(){ //Flash 初始化函数
	var a={};
	//定义变量为Object 类型
	a.title = "房屋效果图"; //设置组件头部名称
	
	a.FormName = "file1";
	//设置Form表单的文本域的Name属性
	
	a.url="/ui/js/upobject/update.php"; 
	//设置服务器接收代码文件
	var tp = document.getElementById('type').value;
	
	a.parameter="type="+tp; 
	//设置提交参数，以GET形式提交
	
	a.typefile=["Images (*.gif,*.png,*.jpg,*jpeg)","*.gif;*.png;*.jpg;*.jpeg;","GIF (*.gif)","*.gif;","PNG (*.png)","*.rar;","JPEG (*.jpg,*.jpeg)","*.jpg;*.jpeg;"];
	//设置可以上传文件 数组类型
	//"Images (*.gif,*.png,*.jpg)"为用户选择要上载的文件时可以看到的描述字符串,
	//"*.gif;*.png;*.jpg"为文件扩展名列表，其中列出用户选择要上载的文件时可以看到的 Windows 文件格式，以分号相隔
	//2个为一组，可以设置多组文件类型
	
	a.UpSize=2;
	//可限制传输文件总容量，0或负数为不限制，单位MB
	
	a.fileNum=5;
	//可限制待传文件的数量，0或负数为不限制
	
	a.size=1000;
	//上传单个文件限制大小，单位MB，可以填写小数类型
	
	a.FormID=['select','select2'];
	//设置每次上传时将注册了ID的表单数据以POST形式发送到服务器
	//需要设置的FORM表单中checkbox,text,textarea,radio,select项目的ID值,radio组只需要一个设置ID即可
	//参数为数组类型，注意使用此参数必须有 challs_flash_FormData() 函数支持
	
	a.CompleteClose=true;
	//设置为true时，上传完成的条目，将也可以取消删除条目，这样参数 UpSize 将失效, 默认为false
	
	a.repeatFile=true;
	//设置为true时，可以过滤用户已经选择的重复文件，否则可以让用户多次选择上传同一个文件，默认为false
	
	a.returnServer=true;
	//设置为true时，组件必须等到服务器有反馈值了才会进行下一个步骤，否则不会等待服务器返回值，直接进行下一步骤，默认为false
	
	return a ;
	//返回Object
}

function challs_flash_onComplete(a){ //每次上传完成调用的函数，并传入一个Object类型变量，包括刚上传文件的大小，名称，上传所用时间,文件类型
	var name=a.fileName; //获取上传文件名
	var size=a.fileSize; //获取上传文件大小，单位字节
	var time=a.updateTime; //获取上传所用时间 单位毫秒
	var type=a.fileType; //获取文件类型，在 Windows 上，此属性是文件扩展名。 在 Macintosh 上，此属性是由四个字符组成的文件类型
	//document.getElementById('show').innerHTML+=name+' --- '+size+'字节 ----文件类型：'+type+'--- 用时 '+(time/1000)+'秒<br><br>'
}

function challs_flash_onCompleteData(a){ //获取服务器反馈信息事件
	document.getElementById('show').innerHTML+=a;	
}
function challs_flash_onStart(a){ //开始一个新的文件上传时事件,并传入一个Object类型变量，包括刚上传文件的大小，名称，类型
	var name=a.fileName; //获取上传文件名
	var size=a.fileSize; //获取上传文件大小，单位字节
	var type=a.fileType; //获取文件类型，在 Windows 上，此属性是文件扩展名。 在 Macintosh 上，此属性是由四个字符组成的文件类型
	//document.getElementById('show').innerHTML+=name+'开始上传！<br />';
}

function challs_flash_onCompleteAll(a){ //上传文件列表全部上传完毕事件,参数 a 数值类型，返回上传失败的数量
	document.getElementById('show').innerHTML+='<font color="#ff0000">所有文件上传完毕，</font>上传失败'+a+'个！<br />';
	//window.location.href='http://www.aaa.cn/update'; //传输完成后，跳转页面
}

function challs_flash_onError(a){ //上传文件发生错误事件，并传入一个Object类型变量，包括错误文件的大小，名称，类型
	var err=a.textErr; //错误信息
	var name=a.fileName; //获取上传文件名
	var size=a.fileSize; //获取上传文件大小，单位字节
	var type=a.fileType; //获取文件类型，在 Windows 上，此属性是文件扩展名。 在 Macintosh 上，此属性是由四个字符组成的文件类型
	document.getElementById('show').innerHTML+='<font color="#ff0000">'+name+' - '+err+'</font><br />';
}

function challs_flash_FormData(a){ // 使用FormID参数时必要函数
	try{
		var value = '';
		var id=document.getElementById(a);
		if(id.type == 'radio'){
			var name = document.getElementsByName(id.name);
			for(var i = 0;i<name.length;i++){
				if(name[i].checked){
					value = name[i].value;
				}
			}
		}else if(id.type == 'checkbox'){
			if(id.checked){
				value = id.value;
			}
		}else{
			value = id.value;
		}
		return value;
	 }catch(e){
		return '';
	 }
}