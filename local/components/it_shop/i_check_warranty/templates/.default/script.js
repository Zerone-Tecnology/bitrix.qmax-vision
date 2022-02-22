$('body').on('click','.j_check_warranty_form_submit',function(){
	var $th = $(this);
	var form = $th.parents('.j_form_warranty');
	form.find('.j_check_warranty_response').remove();
	var $code = form.find('input[name="code"]').val();
	if( $code.length > 0 )
	{
		$.ajax({
			url: '/local/templates/ilab_it_shop/ilab/ajax/check_warranty.php',
			type: "POST",
			data: 'code=' + $code,
			success: function( result ) {
				var data = JSON.parse(result);
				if( data.status )
				{
					form.find('input[name="code"]').val('');
					$th.parent().append('<div class="i_check_warranty_response j_check_warranty_response">ТОВАР БЫЛ КУПЛЕН: ' + data.date + '</div>');
				}
				else
				{
					form.find('input[name="code"]').val('');
					$th.parent().append('<div class="i_check_warranty_response i_error j_check_warranty_response">Данные отсутствуют</div>');
				}
			}
		});
	}
});
