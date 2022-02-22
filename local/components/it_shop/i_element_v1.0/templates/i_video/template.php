<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>

	<?$this->AddEditAction($arResult['ITEMS'][0]['ID'], $arResult['ITEMS'][0]['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
	$this->AddDeleteAction($arResult['ITEMS'][0]['ID'], $arResult['ITEMS'][0]['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>

	<div class="i_youtube" id="<?=$this->GetEditAreaId($arResult['ITEMS'][0]['ID'])?>">
		<iframe width="100%" height="350" src="https://www.youtube.com/embed/<?=$arResult['ITEMS'][0]['PRO']['VIDEO_'.$l]['VALUE']?>?showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe>
	</div>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>