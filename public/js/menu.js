/* JS Document */

$(function(){
/*menu菜单部分*/
	$('div.menu_nav ul').children('li').click(function(){
		var men = $(this);
		men.children('dl.subClass').toggle(100,function(){
			if($(this).is(':hidden')) {
				$(this).siblings(".yia").css('background-position', '10px -102px');
			}else{
				$(this).siblings(".yia").css('background-position', '10px -157px');
			}
		});
	});

	$('li dl.subClass').click(function(event){
		event.stopPropagation();
	});
/*menu菜单部分*/
	$('#quanbu').click(function(){
		$(this).siblings().addClass('action');
	});
	/*更多选项*/
	$('div.public_b').click(function(){
		$('.tbodys').removeClass('action');
		$(this).addClass('action');
		$('div.public_c').removeClass('action');
	});
	$('div.public_c').click(function(){
		$('.tbodys').addClass('action');
		$('div.public_b').removeClass('action');
		$(this).addClass('action');
	});

	//导入表格按钮 触发选择文件按钮
	$('button.inexcelbtn').on('click',function(){
		$('#inexcelfile').trigger('click');
		return false;
	});

	//导入表格按钮 触发表单提交按钮
	$('button.inexcelsubmit').on('click',function(){
		if ($('#inexcelfile').val()) {
			$('#inexcelform').trigger('submit');
		}else{
			var d = dialog({
			    title: '提示！',
			    content: '请选择需要上传的文件！',    
			});

			d.show();
		}
		return false;
	});
});
