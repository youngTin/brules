// JavaScript Document
var gatherid;
var opStep=1;
var tmpfile='';
var gatherTotal=0;
var timeTotal=0;
var maxnum=15;
var contentTotal=0;
var operate = document.getElementById('operate');
//var http = new ActiveXObject("Microsoft.XMLHTTP");

function gather(gid){
	document.getElementById('msg').style.display = '';
	operate.style.display = '';
	gatherid=gid;
	opStep=1;
	tmpfile='';
	gatherTotal=0;
	timeTotal=0;
	maxnum=15;
	contentTotal=0;
	var queryString = "&action=start&";
	queryString += "gid="+gatherid+"&";
	queryString += "step="+opStep+"&";
	queryString += "tmpfile="+tmpfile;
	var listurl = url+queryString;
	xhr = new XHR('showStat');
	xhr.get(listurl);
	//document.write(listurl);
}

function showStat(res){
	var msgArray = res.split("|");
	var stat = msgArray[0];
	var gatherNum = parseInt(msgArray[1]);
	var spendTime = parseFloat(msgArray[2]);
	gatherTotal+= gatherNum;
	timeTotal+= spendTime;
	tmpfile = msgArray[3];
	if(opStep==1){
		operate.innerHTML="���ڷ����б�ҳ........"
	}else{
		operate.innerHTML="���ڷ����б�ҳ........(STEP"+opStep+")";
	}		
	if(gatherNum>0){
		operate.innerHTML+="<BR />�ɹ���ȡ�б�ҳ "+gatherNum+" �����ʱ "+spendTime+" �롣";
	}else{
		operate.innerHTML+="<BR />�����б�ҳʧ�ܣ���������״���Լ���زɼ�����.";
	}
	if(stat=='continue'){
		opStep++;			
		operate.innerHTML+="<BR />������һ��........."
		gather(gatherid);
	}else if(stat=='complete'){
		if(gatherTotal==0){
			operate.innerHTML="�����б�ҳ����,û�л�ȡ���κη���Ҫ�������ҳ,�ɼ�����.";
			setTimeout('closeMsg()',3000);
			return;
		}
		operate.innerHTML="�б��������������ʱ "+timeTotal+" �롣<BR>���ڿ�ʼ�ɼ�����ҳ(�ϼ�"+gatherTotal+"����Ϣ).............";
		opStep=1;
		timeTotal=0;
		gatherContent();
	}else{
		alert('�ɼ����̳����쳣�������ж�');
		setTimeout('closeMsg()',3000);
		return;
	}
}

function gatherContent(){
	var queryString = "&action=start&job=getcontent&";
	queryString += "gid="+gatherid+"&";
	queryString += "maxnum="+maxnum+"&";
	queryString += "step="+opStep+"&";
	queryString += "tmpfile="+tmpfile+"&";
	var xhr2 = new XHR('startGather');
	var contenturl = url+queryString;
	xhr2.get(contenturl);
	//document.write(contenturl);
	/*
	http.open("post", url, true);
	http.onreadystatechange = startGather;
	http.setRequestHeader("Content-Type", contentType);
	http.send(queryString);	
	*/
}

function startGather(res){
	var numArray = res.split("|");
	var stat = numArray[0];
	var validNum = numArray[1];
	var filtreitNum = numArray[2];
	var spendTime = parseFloat(numArray[3])
	timeTotal+= spendTime;
	contentTotal += parseInt(validNum);
	operate.innerHTML="�ɹ��ɼ� "+validNum+" �����ݣ������ظ���ַ "+ filtreitNum+" ������������ʱ "+spendTime+" ��";
	if(stat=='complete'){
		operate.innerHTML+="<BR>����ҳ�ɼ����, total "+contentTotal+"����ʱ "+timeTotal+" �� ";
		setTimeout('closeMsg()',3000);
		return;
	}else if(stat=='continue'){
		operate.innerHTML+="<BR>(STEP "+opStep+" ) �Զ�������һ��.........";
		opStep++;
		gatherContent();
	}else{
		//alert(stat);
		alert('�ɼ������쳣���󣬱�����ֹ');
		setTimeout('closeMsg()',3000);			
		return;
	}
}

function closeMsg(){
	document.getElementById('msg').style.display='none';
}