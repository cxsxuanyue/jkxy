/*
	添加班期的js代码
 */
function checkNNT()
{
	//获取最大人数
	 max=$("input[name='clscount']").val();	
	var classname=$("#classname").val();
	if(classname>0){
		//获取座位数
		seat=$("input[name='seat']").val();
		if((seat-max)>5){
			if (!confirm("操作失败，座位数最多多余最大人数5个！")) {
	            window.event.returnValue = false;
	        }
		}else{
			$("#form").submit();
		}
	}else{
		if (!confirm("班期名称不能为0或负数且只能为数字！")) {
	            window.event.returnValue = false;
	        }
	}
}