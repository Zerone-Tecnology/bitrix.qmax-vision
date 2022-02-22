<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var $arResult
 *  @var $arParams*/
$this->setFrameMode(true);
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__, LANGUAGE_ID);
?>
<div class="i_call_me">
	<div class="i_call_me_wrap">
		<div class="i_call_me_form_wrap j_call_me_form_wrap">
			<div class="i_call_me_form_tt">
				<div class="i_call_me_form_tt_icon"></div>
				Заказать обратный звонок
				<div class="i_call_me_form_tt_str_icon"></div>
			</div>
			<div class="i_call_me_form_cnt">
				<div class="i_call_form_dialog">
					<div class="i_call_me_form_dialog_cnt j_chat_form_dialog_cnt ">
						Будем рады Вас проконсультировать по вопросом кредитования для физических лиц.
					</div>
				</div>
				<form action="" method="POST" name="send_chat" class="i_call_me_form">
					<div class="i_call_me_input">
						<input type="tel" placeholder="Введите ваш номер">
					</div>
					<input type="submit" name="send" class="i_call_me_form_button j_chat_form_button" value="Жду звонка">
					<div class="i_call_button_str_icon"></div>
				</form>
			</div>
		</div>
		<div class="i_call_me_icon j_chat_icon"></div>
	</div>
</div>

<script>
	$(document).ready(function()
	{
		/** ----------------------------------------- j_chat_icon */

		$(document).mouseup(function (e)
		{
			$('body').on('click','.j_chat_icon',function()
			{
				var $item = $('.j_call_me_form_wrap');
				if ($item.is(':visible') == true)
				{
					$item.hide();
				}
				else
				{
					$item.show();
				}
			});

			var div = $(".j_call_me_form_wrap");
			if (!div.is(e.target) && div.has(e.target).length === 0)
			{
				div.hide();
			}
		});

		$(document).keydown(function(e)
		{
			if (e.keyCode == 27)
			{
				$('.j_call_me_form_wrap').hide();
			}
		});
	});
</script>