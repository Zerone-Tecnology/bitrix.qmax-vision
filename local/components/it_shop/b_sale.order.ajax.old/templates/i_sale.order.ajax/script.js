// ------------------------------------------ проверка email
$('.j_request_email').on('input', function(){
	var th = $(this);
	var wrap = th.siblings('.j_response_email');
	var email = th.val();
	if(email != '') {
		var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
		if(pattern.test(email))
		{
			$.post(
				"/local/templates/ilab_it_shop/ilab/ajax/email_verification.php",
				{
					email: email
				},
				onAjaxSuccess
			);
			function onAjaxSuccess(data)
			{
				if(data != 'false')
				{
					wrap.find('.j_response_email_title').html('Аккаунт уже существует, пожалуйста авторизуйтесь');
					wrap.find('.j_response_email_content').html($('.i_basket_form'));
					$('.i_basket_form').find('.j_user_login').val(email);
					$('.i_basket_form').removeClass('idnone');
					wrap.removeClass('idnone');
				}
				else
				{
					wrap.find('.j_response_email_title').html('<span class="greencolor">Аккаунт свободен</span>');
					$('.i_basket_form').addClass('idnone');
					wrap.removeClass('idnone');
				}
			}
		}
		else
		{
			wrap.find('.j_response_email_title').html('<span class="redcolor">Введите правильные данные</span>');
			$('.i_basket_form').addClass('idnone');
			wrap.removeClass('idnone');
		}
	}
});

$('body').on('click', '.j_but_submit', function(){
	var wrap = $('#jq_auth_form');
	var $email = wrap.find('.j_user_login').val();
	var $pass = encodeURIComponent(wrap.find('.j_user_password').val());
	console.log($email + ' | ' + $pass);
	var $vv = $.ajax({
		url: '/local/templates/ilab_it_shop/ilab/ajax/password_check.php',
		type: 'POST',
		async: false,
		dataType: 'json',
		data: 'email='+$email+'&pass='+$pass,
		success: function(data){
			if(data['result'] !== 'yes'){
				wrap.find('.j_error_response').html('<span class="icolorred">Не правильный логин или пароль!</span>').fadeIn();
                /*$('.j_request_email').val($email);*/
			}
			return data;
		}
	});
	if($vv['responseJSON']['result'] == 'yes')
		location.reload();
	else
		return false;
});

$('body').on('click', '.j_remind_pass', function(){
	var wrap = $(this).parents('#jq_auth_form');
	var login = wrap.find('.j_user_login').val();
	$.post(
		"/local/templates/ilab_it_shop/ilab/ajax/remind_pass.php",
		{
			login: login
		},
		onAjaxSuccess
	);
	function onAjaxSuccess(data)
	{
		if(data == 'true') $('.j_be_pass_new_pass').addClass('be_pass_row').html('<span class="greencolor">Новый пароль выслан на почту!</span>');
		else
		{
			$('.j_be_pass_new_pass').addClass('be_pass_row').html(data);
			// $('.j_be_pass_new_pass').addClass('be_pass_row').html('<span class="redcolor">Такого пользователя не существует!</span>');
		}
	}
});

function i_pp_checked(event) {
	if($('#i_pp_check').is(':checked')) {
		$('.checkout.i_but_ac').attr('onclick', 'submitForm("Y"); return false;');
	}
	else {
		$('.checkout.i_but_ac').attr('onclick', '');
	}
}
$('body').on('change', '#i_pp_check', i_pp_checked);
