<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>
	<div class="i_cs">
		<?if($arParams['DISPLAY_TOP_PAGER'])
			echo $arResult['NAV_STRING']?>
		<div class="i_cs_block i_cs_in">
			<?foreach ($arResult['ITEMS'] as $k=>$e):
				$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				if( is_int($k/$arParams['LINE_ELEMENT_COUNT']) && $k!=0 ):?>
			<?/*<div class="iclear"></div>
		</div>
		<div class="i_cs_block">*/?>
				<?endif?>

				<?i_showItem($APPLICATION, array('I_BASE_CURRENCY'=>$arResult['I_BASE_CURRENCY'], 'EDIT'=>$this->GetEditAreaId($e['ID']), 'FROM'=>'SECTION_LIST'), $e, $arParams, $arResult['CAT_PRICES'])// path of function - /local/templates/ilab_it_shop/ilab/php/item.php?>

			<?endforeach?>
		</div>
		<?if($arParams['DISPLAY_BOTTOM_PAGER'])
			echo $arResult['NAV_STRING']?>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>