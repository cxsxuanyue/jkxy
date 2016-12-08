$(function(){
	var msg = '';
    var chkName  = false;
    var chkEmail = false;
    var chkPhone = false;
    // var chkPhone1 = false;	//第二个电话号码
    var chkQQ	 = false;
    var chkRec	 = false; 	//咨询记录
    var chkRek	 = false; 	//备注
	var chkRet	 = false;	//验证回访内容
	var chkPt	 = false;	//验证计划回访时间
	var chkIt	 = false;	//验证意向就读时间
	var chkPret	 = false;	//验证计划回访内容
	var chkSch   = false;	//验证学校
	var chkType  = false;	//验证类型
	var chkUname = false;	//验证紧急用户名
	var chkNow	 = false;	//验证目前所在地
	var chkDst	 = false;	//验证学习目的
	var chkEdu	 = false;	//验证学历
	var chkFrom	 = false;	//验证客户来源
	var chkJob   = false;	//从事行业
	var chkMaj	 = false;	//就读专业

	var msgs;				//按钮确认信息
	var action;				//表单提交地址
	var doAction	= false;
	var doDelete	= false;

	//所有的消息都清空
	function clearMsg(){
		$('#returntime_success').empty();
		$('#returntime_error').empty();
		$('#plancontent_success').empty();
		$('#plancontent_error').empty();
		$('#intentiontime_success').empty();
		$('#intentiontime_error').empty();
		$('#nowstatus_success').empty();
		$('#nowstatus_error').empty();
		$('#studydst_success').empty();
		$('#studydst_error').empty();
		$('#education_success').empty();
		$('#education_error').empty();
		$('#visitsource_success').empty();
		$('#visitsource_error').empty();
		$('#clientsource_success').empty();
		$('#clientsource_error').empty();
		$('#job_success').empty();
		$('#job_error').empty();
		$('#major_success').empty();
		$('#major_error').empty();
	}

	//类别必须填写
	function checkType(){
		chkType = false;
		msg = '';
		$('#classify_error').empty();
		$('#classify_success').empty();

		var pret = $('#plancontent');
		var pt = $('#returntime');
		var it = $('#intentiontime');
		//获取类别的值
		var value = $('#classify').val();
		if(value==''){
			clearMsg();
			msg = '类别不能为空';
			/*
			i.         34-A类客户规则：在之前的基础上，(目前所在地)、学习目的、目前状况、学历、客户来源、意向就读日期、计划回访日期、计划回访内容为必填项、就读专业、从事行业；

              ii.         35-B类客户规则：在之前的基础上，目前所在地、学习目的、目前状况、学历、客户来源、计划回访日期、计划回访内容为必填项；

             iii.         36-C类客户规则：计划回访日期、计划回访内容为必填项；

             iv.         37-D类客户规则：不设要求

               v.         不详客户规则：计划回访日期、计划回访内容为必填项；

			*/
		}else if(value == 34){
			clearMsg();
			checkJob();		//从事行业
			checkMaj();		//就读专业
			checkNow();		//目前状态
			checkDst();		//学习目的
			checkEdu();		//学历
			checkFrom();	//客户来源
			checkPret(pret);	//计划回访内容
			checkPt(pt);		//计划回访时间
			checkIt(it);		//意向就读时间
			if(chkNow && chkDst && chkEdu && chkFrom && chkPt && chkPret && chkIt && chkJob && chkMaj){
				msg = '输入正确';
				chkType = true;
			}else{
				msg = '还有必选项没有填写';
			}
		}else if(value == 35){
			clearMsg();
			checkNow();		//目前状态
			checkDst();		//学习目的
			checkEdu();		//学历
			checkFrom();	//客户来源
			checkPret(pret);	//计划回访内容
			checkPt(pt);		//计划回访时间
			if(chkNow && chkDst && chkEdu && chkFrom && chkPt && chkPret){
				msg = '输入正确';
				chkType = true;
			}else{
				msg = '还有必选项没有填写';
			}
		}else if(value == 36 || value == 67){
			clearMsg();
			checkPret(pret);	//计划回访内容
			checkPt(pt);		//计划回访时间

			if(chkPt && chkPret){
				msg = '填写正确';
				chkType = true;
			}else{
				msg = '有必选项没有填写';
			}
		}else if(value == 37){
			clearMsg();
			chkType = true;
			msg = '各个选项不做要求';
		}

		if(chkType){
			$('#classify_success').html(msg);
		}else{
			$('#classify_error').html(msg);
		}
	}

	//客户等级改变事件
	$('#classify').live('change',function(){
		checkType();
	});

	//目前状况必须填写
	function checkNow(){
		chkNow = false;
		msg = '';
		$('#nowstatus_success').empty();
		$('#nowstatus_error').empty();
		//获取目前的状态值
		var value = $('#nowstatus').val();
		if(value==''){
			msg = '目前状态未填写';
		}else{
			msg = '输入正确';
			chkNow = true;
		}
		if(chkNow)
			$('#nowstatus_success').html(msg);
		else
			$('#nowstatus_error').html(msg);
	}

	//目前状态发生改变事件
	$('#nowstatus').change(function(){
		checkNow();
		checkType();
	})

	//目前状况必须填写
	function checkJob(){
		chkJob = false;
		msg = '';
		$('#job_success').empty();
		$('#job_error').empty();
		//获取目前的状态值
		var value = $('#job').val();
		if(value==''){
			msg = '从事行业未填写';
		}else{
			msg = '输入正确';
			chkJob = true;
		}
		if(chkJob)
			$('#job_success').html(msg);
		else
			$('#job_error').html(msg);
	}
	//从事行业改变事件
	$('#job').live('change',function(){
		checkJob();
	});

	//验证就读专业
    function checkMaj(obj){
        chkMaj = false;
        //删除客户输入的空格
        var value = $.trim($(obj).val());
        //正则匹配汉字
        var reg = /^[\u4e00-\u9fa5]+$/;
        if(value == ''){
        	msg = '就读专业未填写';
        }else if(!reg.test(value)){
        	msg = '就读专业只能输入汉字';
        }else{
        	msg = '输入正确';
        	chkMaj = true;
        }
    }

    //验证就读专业失去焦点
    $('#major').blur(function(){
		msg = '';
    	$('#major_success').empty();
    	$('#major_error').empty();
    	checkMaj(this);
    	if(chkMaj){
            $('#major_success').html(msg);
        }else{
            $('#major_error').html(msg);
        }
    });

	//学习目的必须填写
	function checkDst(){
		chkDst = false;
		msg = '';
		$('#studydst_success').empty();
		$('#studydst_error').empty();
		//获取学习目的状态值
		var value = $('#studydst').val();
		if(value==''){
			msg = '学习目的未填写';
		}else{
			msg = '输入正确';
			chkDst = true;
		}
		if(chkDst)
			$('#studydst_success').html(msg);
		else
			$('#studydst_error').html(msg);
	}

	//学习目的下拉框发生改变事件
	$('#studydst').change(function(){
		checkDst();
		checkType();
	})

	//学历必须填写
	function checkEdu(){
		chkEdu = false;
		msg = '';
		$('#education_success').empty();
		$('#education_error').empty();
		//获取学历的状态值
		var value = $('#education').val();
		if(value==''){
			msg = '学历未填写';
		}else{
			msg = '输入正确';
			chkEdu = true;
		}
		if(chkEdu)
			$('#education_success').html(msg);
		else
			$('#education_error').html(msg);
	}

	//学历的下拉框发生改变事件
	$('#education').change(function(){
		checkEdu();
		checkType();
	})

	//验证客户来源(百度,视频,论坛等)
	function checkFrom(){
		chkFrom = false;
		msg = '';
		$('#visitsource_success').empty();
		$('#visitsource_error').empty();
		//获取客户来源的值
		var value = $('.visitsource').val();
		if(value==''){
			msg = '客户来源未填写';
		}else{
			msg = '输入正确';
			chkFrom = true;
		}
		if(chkFrom)
			$('#visitsource_success').html(msg);
		else
			$('#visitsource_error').html(msg);
	}

	//学历的下拉框发生改变事件
	$('.visitsource').change(function(){
		checkFrom();
		checkType();
	})

	//验证计划回访时间
	function checkPt(obj){
		chkPt = false;
		msg = '';
		$('#returntime_success').empty();
		$('#returntime_error').empty();
		//删除空格
		var value = $.trim($(obj).val());
		//正则匹配汉字
		var reg = /[0-9\-]{10}/;
		if(value == ''){
			msg = '计划回访时间未填写';
		}else if(!reg.test(value)){
			msg = '格式：2015-01-01';
		}else{
			msg = '输入正确';
			chkPt = true;
		}
		if(chkPt){
			$('#returntime_success').html(msg);
		}else{
			$('#returntime_error').html(msg);
		}
	}

	//计划回访时间失去焦点
	$('#returntime').blur(function(){
		checkPt(this);
		checkType();
	})

	//验证计划回访内容
	function checkPret(obj){
		chkPret = false;
		msg = '';
		$('#plancontent_success').empty();
		$('#plancontent_error').empty();
		//删除空格
		var value = $.trim($(obj).val());
		//正则匹配汉字
		var reg = /^[\u4e00-\u9fa5]+$/;
		if(value == ''){
			msg = '计划回访内容未填写';
		}else if(!reg.test(value)){
			msg = '回访内容必须是汉字';
		}else{
			msg = '输入正确';
			chkPret = true;
		}
		if(chkPret){
			$('#plancontent_success').html(msg);
		}else{
			$('#plancontent_error').html(msg);
		}
	}

	//计划回访内容失去焦点
	$('#plancontent').blur(function(){
		checkPret(this);
		checkType();
	})

	//验证意向就读时间
	function checkIt(obj){
		chkIt = false;
		msg = '';
		$('#intentiontime_success').empty();
		$('#intentiontime_error').empty();
		//删除空格
		var value = $.trim($(obj).val());
		//正则匹配汉字
		var reg = /[0-9\-]{10}/;
		if(value == ''){
			msg = '意向就读时间未填写';
		}else if(!reg.test(value)){
			msg = '格式：2015-01-01';
		}else{
			msg = '输入正确';
			chkIt = true;
		}
		if(chkIt){
			$('#intentiontime_success').html(msg);
		}else{
			$('#intentiontime_error').html(msg);
		}
	}

	//意向就读时间失去焦点
	$('#intentiontime').blur(function(){
		checkIt(this);
		checkType();
	})

	//验证紧急用户名
    function checkUname(obj){
        chkUname = false;
        //删除客户输入的空格
        var value = $.trim($(obj).val());
        //正则匹配汉字
        var reg = /^[\u4e00-\u9fa5]+$/;
        if(value == ''){
        	chkUname = true;
        }else if(!reg.test(value)){
        	msg = '姓名只能输入汉字';
        }else{
        	msg = '输入正确';
        	chkUname = true;
        }
    }

	//验证紧急联系人失去焦点事件
    $('#urg_name').blur(function(){
		msg = '';
    	$('#urg_name_success').empty();
    	$('#urg_name_error').empty();
    	checkUname(this);
    	if(chkUname){
            $('#urg_name_success').html(msg);
        }else{
            $('#urg_name_error').html(msg);
        }
    });

    //验证用户名
    function checkName(obj){
        chkName = false;
        //删除客户输入的空格
        var value = $.trim($(obj).val());
        //正则匹配汉字
        var reg = /^[\u4e00-\u9fa5]+$/;
        if(value == ''){
        	msg = '姓名不能为空';
        }else if(!reg.test(value)){
        	msg = '姓名只能输入汉字';
        }else{
        	msg = '输入正确';
        	chkName = true;
        }
    }

    //用户名失去焦点事件
    $('#stuname').blur(function(){
		msg = '';
    	$('#stuname_success').empty();
    	$('#stuname_error').empty();
    	checkName(this);
    	if(chkName){
            $('#stuname_success').html(msg);
        }else{
            $('#stuname_error').html(msg);
        }
    });

    //邮箱验证
    function checkEmail(obj){
		chkEmail = false;
		//正则匹配邮箱
		var reg = /^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

		//删除客户输入的空格
        var value = $.trim($(obj).val());
		if(value == ''){
			chkEmail = true;
			return;
		}else if(!reg.test(value)){
			msg = "请输入正确的邮箱";
		}else{
			msg = "邮箱输入正确";
			chkEmail = true;
		}
	}

	//邮箱失去焦点事件
	$('#email').blur(function(){
		msg = '';
		$('#email_success').empty();
    	$('#email_error').empty();
		checkEmail(this);
		if(chkEmail){
            $('#email_success').html(msg);
        }else{
            $('#email_error').html(msg);
        }
	});

	function getLocalTime(time){
	   return new Date(parseInt(time) * 1000).toLocaleString().replace(/[\u4e00-\u9fa5]{2}/,'');
	}

	//send():发送phone和qq的Ajax验证函数
	function send(k,v){
		var res = false;
		$.ajax({
   	 			url:host+'/same/verify',
   	 			type:'get',
   	 			dataType:'json',
   	 			data:'control='+k+'&value='+v,
   	 			async: false,
   	 			success:function(data){
   	 				// console.log(data.length);
   	 				if(data.info == 1){	//电话或者qq正确，无重复
   	 					$('#phone_addr').html(data.area.MobileArea);
   	 					res = true;
   	 				}else if(data == 2){	//qq传来的值
   	 					res = true;
   	 				}else if(data == 3){	//重复数据较多，需要跳转页面重新查询
   	 					window.location = host+'/online/index/'+k+'/'+v;
						return false;
   	 				}else{
   	 					//var result = confirm('该客户已经存在,需要补全信息吗');	//查询的结果只有一条信息
   	 					art.dialog({
   	 						with:500,
   	 						height:100,
   	 						title:'<span style="color:red">注意(3秒后关闭...)</span>',
   	 						content:'<span style="font-size:14px;"><b>该客户已经存在,信息将自动补全</b></span>',
						    time: 3000
						});
						// 获取到该用户的所有信息分配到各个表单中
						$('#stuname').val(data.stuname);
						$('input[name="clientsource"][value="'+data.clientsource+'"]').attr('checked',true);
						$('input[name="visitsource"][value="'+data.visitsource+'"]').attr('checked',true);
						$('input[name="intentionschool"][value="'+data.intentionschool+'"]').attr('checked',true);
						$('input[name="intentionsubject"][value="'+data.intentionsubject+'"]').attr('checked',true);
						$('#phone').val(data.phone);
						$('#qq').val(data.qq);
						$('#urg_name').val(data.urg_name);
						$('#urg_tel').val(data.urg_tel);
						$('#urg_relation').val(data.urg_relation);
						$('#email').val(data.email);
						$('input[name="stusex"][value="'+data.stusex+'"]').attr('checked',true);
						$('#intentiontime').val(getLocalTime(data.intentiontime));
						$('#returntime').val(getLocalTime(data.returntime));
						$('#classify option[value="'+data.classify+'"]').attr('selected','selected');
						$('#cintent option[value="'+data.cintent+'"]').attr('selected','selected');
						$('#nowstatus option[value="'+data.nowstatus+'"]').attr('selected','selected');
						$('#education option[value="'+data.education+'"]').attr('selected','selected');
						$('#job option[value="'+data.job+'"]').attr('selected','selected');
						$('#studydst option[value="'+data.studydst+'"]').attr('selected','selected');
						$('#major').val(data.major);
						$('#school').val(data.school);
						$('#consultrecord').val(data.consultrecord);
						$('#remark').val(data.remark);

						// $(':input').attr('disabled',true);

						//清空所有的验证信息
						$('[id*="addr"]').empty();
						$('[id*="success"]').empty();
						$('[id*="error"]').empty();
	   	 			}
   	 			}
			});
		return res;
	}

	//手机验证
	function checkPhone(obj){
		chkPhone = false;
		var reg = /^[1][34578][0-9]{9}$|^(0\d{9,11})$/;
		var value = $.trim($(obj).val());

		if(value == ''){
			msg = '手机号码不能为空';
		}else if(!reg.test(value)){
			msg = '手机号码格式不正确';
		}else{
			var res = send('phone',value);
			if(res){
				chkPhone = true;
				return true;
				msg = '手机号码正确';
			}else{
				return;
			}
		}
	}

	//手机失去焦点
	var oldPhone = $('#phone').val();
	$('#phone').blur(function(){
		msg = '';
		$('#phone_addr').empty();
		$('#phone_success').empty();
    	$('#phone_error').empty();

		// 获取失焦后的手机
		var newPhone = $('#phone').val();
		// 判断有没有变化
		if(oldPhone == newPhone) return false;

		checkPhone(this);
		if(chkPhone){
            $('#phone_success').html(msg);
        }else{
            $('#phone_error').html(msg);
        }
	})

	//QQ验证
	function checkQQ(obj){
		chkQQ = false;
		var reg = /^[0-9]{5,12}$/;
		var value = $.trim($(obj).val());

		if(value == ''){
			chkQQ = true;
			return false;
		}else if(!reg.test(value)){
			msg = 'QQ号必须是5-12位的数字';
		}else{
			var itag = send('qq',value);
			if(itag){
				msg = 'QQ号输入正确';
				chkQQ = true;
			}else{
				return false;
			}
		}
	}

	//QQ失去焦点
	var oldQQ = $.trim($('#qq').val());
	$('#qq').blur(function(){
		if(oldQQ == ''){
			chkQQ = true;
			return false;
		}
		// 如果QQ没有变化，则不验证
		var newQQ = $('#qq').val();
		if(oldQQ == newQQ) return false;

		msg = '';
		$('#qq_success').empty();
    	$('#qq_error').empty();

		checkQQ(this);
		if(chkQQ){
            $('#qq_success').html(msg);
        }else{
            $('#qq_error').html(msg);
        }
	})

	//咨询记录
	function checkRec(obj){
		chkRec = false;
		//必须以汉字开始，不过可以有数字
		var reg = /[\u4e00-\u9fa5]*\w*/;
		var value = $.trim($(obj).val());

		if(value == ''){
			msg = '咨询记录不能为空';
		}else if(!reg.test(value)){
			msg = '请输入至少十个汉字';
		}else{
			msg = '咨询记录输入完毕';
			chkRec = true;
		}
	}

	//咨询记录失去焦点
	$('#consultrecord').blur(function(){
		msg = '';
		$('#consultrecord_success').empty();
    	$('#consultrecord_error').empty();
		checkRec(this);
		if(chkRec){
            $('#consultrecord_success').html(msg);
        }else{
            $('#consultrecord_error').html(msg);
        }
	})

	//验证学校
	function checkSch(obj){
		chkSch = false;
		//必须以汉字开始，不过可以有数字
		var reg = /[\u4e00-\u9fa5]+/;
		var value = $.trim($(obj).val());

		if(value==''){
			chkSch = true;
		}else if(!reg.test(value)){
			msg = '请填写正确的学校名称';
		}else{
			msg = '填写正确';
			chkSch = true;
		}
	}

	//学校失去焦点事件
	$('#school').blur(function(){
		msg = '';
		$('#school_success').empty();
    	$('#school_error').empty();
		checkSch(this);
		if(chkSch){
            $('#school_success').html(msg);
        }else{
            $('#school_error').html(msg);
        }
	})

	//备注
	function checkRek(obj){
		chkRek = false;
		//必须以汉字开始，不过可以有数字
		var reg = /[\u4e00-\u9fa5]*\w*/;
		var value = $.trim($(obj).val());

		if(value == ''){
			msg = '备注不能为空';
		}else if(!reg.test(value)){
			msg = '请输入至少10个汉字';
		}else{
			msg = '备注输入完毕';
			chkRek = true;
		}
	}

	//备注失去焦点
	$('#remark').blur(function(){
		msg = '';
		$('#remark_success').empty();
    	$('#remark_error').empty();
		checkRek(this);
		if(chkRek){
            $('#remark_success').html(msg);
        }else{
            $('#remark_error').html(msg);
        }
	})

	//回访内容
	function checkRet(obj){
		chkRet = false;
		msg = '';
		//必须以汉字开始，不过可以有数字
		var reg = /[\u4e00-\u9fa5]*\w*/;
		var value = $.trim($(obj).val());

		if(value == ''){
			chkRet = true;
			return;
		}else if(!reg.test(value)){
			msg = '请输入至少10个汉字';
		}else{
			msg = '输入正确';
			chkRet = true;
		}
	}

	//备注失去焦点
	$('#content').blur(function(){
		msg = '';
		$('#content_success').empty();
    	$('#content_error').empty();
		checkRet(this);
		if(chkRet){
            $('#content_success').html(msg);
        }else{
            $('#content_error').html(msg);
        }
	})

	//籍贯，现居地的级联操作
	$('select[class="pro"]').change(function(){
		var cur = $(this);
		var id = cur.val();
		var value = $(this).attr('data-value');
		$.ajax({
			url:host+'/same/loads',
			type:'get',
			data:{upid:$(this).val()},
			dataType:'json',
			success:function(data){
				cur.next().remove();
				if(data == null) return;
				var info = '<select name="city'+value+'"><option>--请选择--</option>';
				for (var i = 0; i < data.length; i++) {
					info += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
				};
				info += "</select>";
				cur.after(info);
			}
		});
	})

	function getJsonLength(jsonData){
		var jsonLength = 0;

		for(var item in jsonData){
			jsonLength++;
		}

		return jsonLength;
	}

	//通过选择的不同校区对应出校区下的学科
	$('input[name=intentionschool]').live('change',function (){
		// 获取校区的值
		var value = $(this).val();

		// 根据校区获取对应的学科
		var subs = schsub[value];

		var sub = '';
		// 如果学科数目（含分校区的学科）为多少，则这里的15应该改为多少->建议多写几个
		for(var i=1;i<=15;i++){
			if(subs[i]){
				sub += ' <label><input type="radio" name="intentionsubject" value="'+i+'"/> '+subs[i]+'</label>';
			}
		}
		$('.subs').html(sub);
	});

	//一个表单多个提交按钮，需要先发生点击事件，然后在做提交事件
	$("input[class='button']").click(function(){
		var data = $(this).attr('data');
		msgs = '';
		switch(data){
			case 'modify':
				msgs = "确认要提交修改信息吗?";
				action = host+"/offline/update/id/"+id;
				break;
			case 'apply':
				msgs = "确认要报名吗?";
				action = host+"/same/addApply/id/"+id;
				break;
			case 'del':
				doAction = true;
				msgs = "确定要移向公共库吗?";
				action = host+"/same/addCommon/id/"+id;
				break;
			case 'inten':
				msgs = "确定要移向意向库吗?";
				action = host+"/same/addIntention/id/"+id;
				break;
			case 'yes':		//审核通过
				msgs = "确定报名吗?";
				action = host+'/manage/verify/pass/yes/id/'+id;
				break;
			case 'no':		//审核通过
				msgs = "确定将该生退回课程顾问意向库?";
				action = host+'/manage/verify/pass/no/id/'+id;
				break;
			case 'delete':
				doDelete = true;
				msgs = "确定要删除该客户吗？";
				action = host+'/same/delete/id/'+id;
				break;
			case 'appiont':
				art.dialog({
					title: '请选择您要指定的课程顾问!',		//标题
					width: 260,								//宽度
					height: 100,							//高度
					fixed: true,							//固定定位,居中
					lock: true,								//锁屏遮罩, bug双击遮罩层会关闭弹框
					content: str,
					ok: function (){
						var selct = document.getElementById('selct');
						action = host+'/offline/appoint/id/'+id+'/appiont/'+selct.value;
						window.location = action;
						return false;
					},
					okValue: '确定',
					cancel: function () {}
				});
				return false;
				break;
			case 'back':
				window.history.back(-1);
				return false;
				break;
		}
	});

	//课程顾问表单修改事件
	$('#myform').submit(function(){
		$('#stuname').blur();
		$('#email').blur();
		// $('#phone').blur();
		// $('#qq').blur();
		$('#consultrecord').blur();
		$('#remark').blur();
		$('#content').blur();

		if(doAction){
			var res = confirm(msgs);
			if(res){
				$(this).attr('action',action);
				return true;
			}else{
				return false;
			}
		}
		if(doDelete){
			var res = confirm(msgs);
			if(res){
				$(this).attr('action',action);
				return true;
			}else{
				return false;
			}
		}
		checkType();
		// alert(chkName +':'+ chkRec +":"+ chkRek +':'+ chkRet +':'+ chkType)
		//用户名，咨询记录，备注必须填写
		if(chkName && chkRec && chkRek && chkRet && chkType){
			//让用户确认是否提交信息，如果提交信息
			var res = confirm(msgs);
			if(res){
				$(this).attr('action',action);
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	});

	//课程顾问表单提交事件
	$('#addform').submit(function(){
		$('#stuname').blur();
		$('#email').blur();
		$('#phone').blur();
		$('#qq').blur();
		$('#consultrecord').blur();
		// $('#remark').blur();

		//检验列别有没有添加
		checkType();
		//用户名，电话，咨询记录，备注必须填写
		alert(chkName +':'+ chkPhone +':'+ chkRec +':'+ chkQQ +':'+ chkEmail +':'+ chkType);
		if(chkName && chkPhone && chkRec && chkQQ && chkEmail && chkType){
			return true;
		}else{
			return false;
		}
	});

	//咨询师提交表单事件
	$('#onForm').submit(function(){
		$('#stuname').blur();
		$('#email').blur();
		$('#phone').blur();
		$('#qq').blur();
		$('#consultrecord').blur();
		$('#remark').blur();

		if(chkName && chkPhone && chkRec && chkRek && chkQQ && chkEmail){
			return true;
		}else{
			return false;
		}
	})

    //手机号码添加操作
    var num = 1;
    $('.clone').click(function(){
        num++;
        //克隆addPhone的所有
        var addPhone = $('#addPhone').clone();
        //删除input中的id属性

        addPhone.children('a').attr('class', 'close').text('[-]');
        addPhone.children('input').attr({name:'phone'+num, id:'phone'+num, onblur:'verify("phone'+num+'")'}).val('');

        //追加到addInput的最后位置
        $('.addInput').append(addPhone);
    });
    //点击减号删除手机号输入
    $('.close').live('click', function(){
        $(this).parent().remove();
    });

	//身份证号验证
	$('input[name="positionid"]').blur(function(){
		var the = $(this).next('span');
		validateIdCard($(this).val(), the);
	});

	//身份证号验证正则
	function validateIdCard(idCard, the){
		//15位和18位身份证号码的正则表达式
		var regIdCard=/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/;

		//如果通过该验证，说明身份证格式正确，但准确性还需计算
		if(regIdCard.test(idCard)){
		   if(idCard.length==18){
			   var idCardWi=new Array( 7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2 ); //将前17位加权因子保存在数组里
			   var idCardY=new Array( 1, 0, 10, 9, 8, 7, 6, 5, 4, 3, 2 ); //这是除以11后，可能产生的11位余数、验证码，也保存成数组
			   var idCardWiSum=0; //用来保存前17位各自乖以加权因子后的总和
				   for(var i=0;i<17;i++){
					   idCardWiSum+=idCard.substring(i,i+1)*idCardWi[i];
				   }

			  var idCardMod=idCardWiSum%11;//计算出校验码所在数组的位置
			  var idCardLast=idCard.substring(17);//得到最后一位身份证号码

			  //如果等于2，则说明校验码是10，身份证号码最后一位应该是X
			   if(idCardMod==2){
				   if(idCardLast=="X"||idCardLast=="x"){
					   the.text("恭喜通过验证啦！");
				   }else{
					   art.dialog({
							title: '提示',
							width: 300,
							height: 100,
							fixed: true,
							content: '<span style="color:red;">身份证号码错误！</span>',
							okValue: '确定',
							cancel: function () {}
					   });
				   }
			   }else{
				   //用计算出的验证码与最后一位身份证号码匹配，如果一致，说明通过，否则是无效的身份证号码
				   if(idCardLast==idCardY[idCardMod]){
					   the.text("恭喜通过验证啦！");
				   }else{
					   art.dialog({
							title: '提示',
							width: 300,
							height: 100,
							fixed: true,
							content: '<span style="color:red;">身份证号码错误！</span>',
							okValue: '确定',
							cancel: function () {}
					   });
				   }
			   }
		   }
		}else{
		   art.dialog({
				title: '提示',
				width: 300,
				height: 100,
				fixed: true,
				content: '<span style="color:red;">身份证格式不正确！</span>',
				okValue: '确定',
				cancel: function () {}
		   });
		}
	}
})
