$(function(){
	//subject.class.php edit
		$('.addsm').click(function(){
			$('.'+$(this).attr('type')).last().after('<div class="'+$(this).attr('type')+' p10"><input type="hidden" name="moneytype[]" value="'+$(this).attr('moneytype')+'"/><input type="hidden" name="department[]" value="'+$(this).attr('department')+'" />学费金额： <input type="text" name="money[]" value="" class="w100"> +<span class="cred">(</span>直降形式： <input type="text" name="sdtype[]" value="" class="w100"/> +直降： <input type="text" name="sdsum[]" value="" class="w50"/><span class="cred">)</span> +<span class="cred">(</span>返现形式： <input type="text" name="cbtype[]" value="" class="w100"/> +金额： <input type="text" name="cbsum[]" value="" class="w50"/><span class="cred">)</span> +备注： <input type="text" name="remark[]"/> <a class="delsm cp">删除</a> </div>');
		})
		$('.delsm').live('click',function(){
			$(this).parent().remove();
		})
	//apply.class.php addMoney
		//初始化表单验证
		var demo = $(".myform").Validform({
			tiptype:3,
			datatype:{
				'float':/\d+\.*\d*/,
				'n4':/^[0-9]{6}$/
			},
		});
		//表单提交
		$('button.addmoney').click(function(){
			$('.myform').submit();
		});
		//更改支付方式
		$('#styleid').change(function(){
			var value = $(this).val();

			if(value == '70'){
				$(this).next().css('display','inline').removeAttr('disabled');
			}else{
				$(this).next().css('display','none').attr('disabled','disabled');
			}
		})
		//更改缴费方式
		$('.paymenttype').change(function(){
			if($('.norpaymentdiv').hasClass('dib')){
				$('.norpaymentdiv').addClass('dn').removeClass('dib');
				$('.spepaymentdiv').addClass('dib').removeClass('dn');
				$('.norpayment').attr('disabled','true'); 
				$('.spepayment').removeAttr('disabled');
			}else{
				$('.spepaymentdiv').addClass('dn').removeClass('dib');
				$('.norpaymentdiv').addClass('dib').removeClass('dn');
				$('.norpayment').removeAttr('disabled');
				$('.spepayment').attr('disabled','true');
			}
		})
		//根据选择的项不一样 出现不同的费用
		$('.68').change(function(){
			$('input[name="cash"]').val($(this).find("option:selected").attr('money'));
			$('input[name="cheapcash"]').val($(this).find("option:selected").attr('sdsum'));
			$('input[name="aftercash"]').val($(this).find("option:selected").attr('money')-$(this).find("option:selected").attr('sdsum'));
			$(this).parent().next('.dib').children('input[name="cbsum"]').val($(this).find("option:selected").attr('cbsum'));
		})
		$('.71').change(function(){
			$('input[name="loan"]').val($(this).find("option:selected").attr('money'));
			$('input[name="cheaploan"]').val($(this).find("option:selected").attr('sdsum'));
			$('input[name="afterloan"]').val($(this).find("option:selected").attr('money')-$(this).find("option:selected").attr('sdsum'));
			$(this).parent().next('.dib').children('input[name="cbsum"]').val($(this).find("option:selected").attr('cbsum')); 
		})
})