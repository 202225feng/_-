function O(obj)
{
	if(typeof obj=='object') return obj
	else return document.getElementById(obj)
}

function S(obj)
{
	return O(obj).style
}

function C(name)
{
	var elements = document.getElementByTagName('*')
	var objects =[]
	for(var i = 0;i<elements.length;i++)
	if(elements[i].className == name)
		objects.push(elements[i])

	return objects
}

function showw(obj)
{
	S(obj).display='';
}
function change(a,b)
{
	S(a).display='none';
	S(b).display='';
}

function ajaxRequest()
	{
		try
		{
			var request=new XMLHttpRequest()
		}
		catch(e1)
		{
			try
			{
				request= new ActiveXObject("Msxml2.XMLHTTP")
			}
			catch(e2)
			{
				try
				{
					request = new ActiveXObject("Microsoft.XMLHTTP")
				}
				catch(e3)
				{
					request = false
				}
			}
		}

		return request
	}
	
function chasore(row,sore)
{
	if(sore.value =='')
	return
	params="row="+row+"&sore="+sore.value;
	request = new ajaxRequest()
	request.open('POST',"change_sore.php",true)
	
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Contection","close");

	request.onreadystatechange = function()
	{
		if(this.readyState == 4)
			if(this.status == 200)
				if(this.responseText != null)
					error="OK";
			}
	request.send(params);
}

function qb_change(qbook)
{
	params="qb_id="+qbook.value;
	request= new ajaxRequest();
	request.open('POST',"quest_bid_change.php",true)
	
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Contection","close");

	request.onreadystatechange = function()
	{
		if(this.readyState == 4)
			if(this.status == 200)
				if(this.responseText != null)
					{
						O('sel_c').innerHTML = this.responseText;
						//alert(this.responseText);
					}
			}
	request.send(params);
}
//s_q(p_id,q_id,num,ans,time)
function s_q(eid,pid,qid,types,num,time)
{
	//alert("123");
	//alert(pid);
	anns='';
	if(num!=0)
	{
		if(types==5)
		{
			ans=document.getElementsByTagName("textarea");
			anns+=ans[0].value;
		}
		else
		{
			ans=document.getElementsByTagName("input");
			for(var i=0;i<ans.length;i++)  
			{

				if(((ans[i].type=="checkbox"||ans[i].type=="radio") && ans[i].name=="ans" && ans[i].checked) || (ans[i].type=="text" && ans[i].name=="ans"))
				{
					//alert(ans[i].value);
					anns+=ans[i].value;
				}
			}
		}
		//alert(anns);
	}
	
	params="eid="+eid+"&pid="+pid+"&qid="+qid+"&types="+types+"&num="+num+"&ans="+anns+"&time="+time;
	request= new ajaxRequest();
	request.open('POST',"show_q.php",true)
	
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Contection","close");

	request.onreadystatechange = function()
	{
		if(this.readyState == 4)
			if(this.status == 200)
				if(this.responseText != null)
					{

						O('main').innerHTML = this.responseText;
						//alert(this.responseText);
					}
			}
	request.send(params);
}
function apply(cid,url)
{
	code=O(ap).value;
	//alert(code);
	params="cid="+cid+"&code="+code;
	request= new ajaxRequest();
	request.open('POST',"group_apply.php",true)
	
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Contection","close");

	request.onreadystatechange = function()
	{
		if(this.readyState == 4)
			if(this.status == 200)
				if(this.responseText != null)
					{
						//alert(this.responseText);
						if(this.responseText==1)
						{
							alert("您已经加入该group");
							window.location.href=url;
						}
						else if(this.responseText==2)
						{
							alert("邀请码错误");
						}
						else
						{
							alert("wrong");
						}
					}
			}
	request.send(params);
}
function change_fen(eid,pid,id,url,cid)
{
//	alert(id);
	params="eid="+eid+"&pid="+pid+"&cid="+cid;
	request= new ajaxRequest();
	request.open('POST',url,true)
	
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Contection","close");

	request.onreadystatechange = function()
	{
		if(this.readyState == 4)
			if(this.status == 200)
				if(this.responseText != null)
					{
						O(id).innerHTML = this.responseText;
						//alert(this.responseText);
					}
			}
	request.send(params);
}
function chafen()
{
//	var tt=array();
	for(var i=1;i<=5;i++)
	{
		tt=O('t'+i).value;
		ff=O('f'+i).innerHTML;
		//alert("tt="+tt+"ff="+ff);
		zz=O('z'+i);
		zz.innerHTML=tt*ff;
	}
}
function sub_fen(eid,pid,cid)
{
	params="eid="+eid+"&pid="+pid;
	for(var i=1;i<=5;i++)
	{
		tt=O('t'+i).value;
		params+="&t"+i+"="+tt;
	}
	request= new ajaxRequest();
	request.open('POST','sub_fen.php',true)
	
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Contection","close");

	request.onreadystatechange = function()
	{
		if(this.readyState == 4)
			if(this.status == 200)
				if(this.responseText != null)
					{
						//O(id).innerHTML = this.responseText;
						alert('OK，5秒后自动跳转');
						url="exam_admin.php?viewc="+cid+"&viewe="+eid;
		window.setTimeout("window.location='"+url+"'",500);

					}
			}
	request.send(params);
}
function trans(flag,eid){
	if(flag==0)
		alert("请批改全部试卷后再统计");
	else
	{
		window.location.href="e_z_info.php?viewe="+eid;
	}
}
function ts(show)
{
	//alert(show);
	O('xx').className="item_a";
	O('ee').className="item_a";
	O('cc').className="item_a";
	O('gg').className="item_a";
	O(show).className="item_a active";
}
function changeinfo(uid,url,iid)
{

	params="cid="+uid;
	//alert(params);
	request= new ajaxRequest();
	request.open('POST',url,true)
	
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Contection","close");

	request.onreadystatechange = function()
	{
		if(this.readyState == 4)
			if(this.status == 200)
				if(this.responseText != null)
					{
						//alert(this.responseText);
						O(iid).innerHTML = this.responseText;
					}
			}
	request.send(params);
}
function show_e_info(uid,eid)
{
	params="viewu="+uid+"&viewe="+eid;
	//alert(params);
	request= new ajaxRequest();
	request.open('POST',"show_e_p_info.php",true)
	
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	//request.setRequestHeader("Content-length",params.length);
	request.setRequestHeader("Contection","close");

	request.onreadystatechange = function()
	{
		if(this.readyState == 4)
			if(this.status == 200)
				if(this.responseText != null)
					{
						//alert(this.responseText);
						O("exam_info").innerHTML = this.responseText;
					}
			}
	request.send(params);
}
