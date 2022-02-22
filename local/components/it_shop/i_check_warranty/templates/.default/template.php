<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var $arResult
 *  @var $arParams*/
use \Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(__FILE__);
$this->setFrameMode(true);
?>
<div class="i_check_warranty">
	<div class="i_check_warranty_form j_form_warranty">
		<div class="i_check_warranty_form_input">
			<input type="text" name="code" placeholder="введите серийный номер">
		</div>
		<div class="i_check_warranty_form_input">
			<div class="i_button i_check_warranty_form_submit j_check_warranty_form_submit">OK</div>
		</div>
	</div>
</div>