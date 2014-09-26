
$(document).ready(function(){
	
	var content = $(document);
	
	$(document).on('click','.btn-include_form_create',function(){
		var form = $(this).parents('table').eq(0);
		var layout= $('tbody.include_layout tr',form);
		var tr = $(layout).clone();
		
		var cnt = $(form).data('new_count') || 0;
		$(form).data('new_count',++cnt);
		
		$('tbody:first',form).append(tr);
		$(':disabled',tr).each(function(ii,input){
			var name = $(input).attr('name');
			name = name.replace('INDEX',cnt*-1);
			$(input)
				.attr('name',name)
				.attr('id','form_'+name)
				.removeAttr('disabled')
			;
		});
		return false;
	});
	
	$(document).on('click','.btn-include_form_delete',function(){
		var tbody = $(this).parents('tbody').eq(0);
		var tr    = $(this).parents('tr').eq(0);
		$(tr).remove();
		return false;
	});

});