//apply/editApply 各项费用的ajax提交
function geajax(url){ 
	ajaxhan('post',url,$('#geform').serialize(),'操作',0,true);
}
//apply/editApply 修改班期ajax提交
function changecls(url){
	var client = {};
	client.intentionschool = $("select[name='intentionschool']").val();
	client.intentionsubject = $("select[name='intentionsubject']").val();
	client.classid = $("select[name='classid']").val();
	client.id = $("input[name='cid']").val();
	ajaxhan('post',url,client,'修改班期',0,true);
}
//apply/editApply 退学ajax提交
function outStudy(url){
	var client = {};
	client.id = $("input[name='cid']").val();
	ajaxhan('post',url,client,'退学',0,true);
}
//apply/editApply 退报名费ajax提交
function rFree(url){
	var client = {};
	client.id = $("input[name='cid']").val();
	ajaxhan('post',url,client,'退报名费',0,true);
}
//apply/sureInfo和apply/editApply费用审核通过 obj代表出发当前时间的元素
function monPass(url,obj){
	var client = {};
	if(obj){
		//费用信息审核使用
		client.id = obj.parent().siblings().first().text();
	}else{
		//报名管理 基本信息审核
		client.id = $("input[name='cid']").val();
	} 
	ajaxhan('post',url,client,'审核',0,true);
}
//apply/receipt 学费收据管理、杂费收据管理 obj代表出发当前时间的元素 getVal代表通过get匹配提交url
function chgreceiptStatus(url,obj,getVal){
	if(obj.attr('name') == 'a'){
		if(getVal == "money"){
			url = url+'/ice';
		}else{
			url = url+'/sice';
		}
	}else if(obj.attr('name') == 'b'){
		if(getVal == "money"){
			url = url+'/unice';
		}else{
			url = url+'/unsice';
		}
	}
	ajaxhan('post',url,client,'审核',0,true);
}
//client/add 录入学员
function areachange(url,areaid){
	var area = {};
	area.id = areaid
	return ajaxhan('get',url,area,'录入学员',1,false)
}

function normalAjax(url,cid){
	//默认加载名字叫atime 的那个input
	var data = $("input[name='atime']").val();
	//都是同步请求
	ajaxhan('post',url,{'atime':data,'cid':cid},'操作',0,false);
}

function jiaowuAjax(data,url,cid){
	//默认加载名字叫atime 的那个input
	var data = $("input[name='atime']").val();
	//都是同步请求
	ajaxhan('post',url,{'atime':data,'cid':cid},'操作',0,false);
}

function zuofeiComputer(url,id){
	//false为同步请求
	ajaxhan('post',url,{'id':id},'操作',0,false);
}

function ajaxhan(type,url,data,msg,rtype,async){
	var area = '';
	$.ajax({
		type: type,
		url: url,
		data: data,
		async:async,
		dataType: "text",
		success: function(data){
			if(rtype != 1){
				switch(data){
					case '0':123
						msg = msg+'失败';
						break;
					case '1':
						msg = msg+'成功';
						break;
					case '2':
						msg = '班级人数已满';
						break;
					case '3':
						msg = '离开班时间不到3天，不能转班';
						break;
				} 
				var d = dialog({
				    title: '提示',
				    content: msg,
				    width:200,
				    ok:function(){
				    	window.location.reload();
				    }
				});
				d.show();
			}else{
				area = data;
			}
		},
		error:function(){
			alert('传输错误，请联系程序')
		}
	})
	return area;
}