<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
/* Леопольд, выходи, подлый трус © Мыши */
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>
	<div class="i_social">
		<?foreach($arResult['ITEMS'] as $k=>$e):
		$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
		$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
			<noindex>
				<a id="<?=$this->GetEditAreaId($e['ID']);?>" class="i_social_item" href="<?=$e['PRO']['LINK']['VALUE']?>" target="_blank" alt="<?=$e['NAME']?>" title="<?=$e['NAME']?>" style="background-image: url(<?=$e['PREVIEW_PICTURE']?>)"></a>
			</noindex>
		<?endforeach?>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>