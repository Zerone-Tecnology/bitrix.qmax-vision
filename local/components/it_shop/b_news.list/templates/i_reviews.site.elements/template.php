<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	if($arParams['DISPLAY_TOP_PAGER'] && $arResult['NAV_STRING'])
		echo $arResult['NAV_STRING'].'<br>'?>

	<div class="i_rse">
		<?foreach($arResult['ITEMS'] as $k=>$e):
			$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($e['IBLOCK_ID'], 'ELEMENT_EDIT'));
			$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($e['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));?>
			<div class="i_rse_ele i_nal_item" id="<?=$this->GetEditAreaId($e['ID']);?>">

				<?	// ----------------------------------------------------------------------------------------------------   DISPLAY_ACTIVE_FROM
				/*if($arParams['DISPLAY_DATE']!='N' && $e['DISPLAY_ACTIVE_FROM']):?>
					<div class="i_rse_date"><?=$e['DISPLAY_ACTIVE_FROM']?></div>
				<?endif*/
					// ----------------------------------------------------------------------------------------------------   DISPLAY_ACTIVE_FROM?>

				<?	// ----------------------------------------------------------------------------------------------------   NAME
				if($arParams['DISPLAY_NAME']!='N' && $e['NAME']):?>
					<div class="i_rse_name">
						<?/*if(!$arParams['HIDE_LINK_WHEN_NO_DETAIL'] || ($e['DETAIL_TEXT'] && $arResult['USER_HAVE_ACCESS'])):?>
							<a href="<?=$e['DETAIL_PAGE_URL']?>"><span<?if($k==0)echo ' class="ifont110"'?>><?=$e['NAME']?></span></a>
						<?else:*/?>
							<b><?=$e['NAME']?></b><?if( $e['PROPERTIES']['PRODUCT']['VALUE'] )echo ':&nbsp;'.$e['PROPERTIES']['PRODUCT']['VALUE']?>
						<?//endif?>
					</div>
				<?endif
					// ----------------------------------------------------------------------------------------------------   NAME?>

				<?	// ----------------------------------------------------------------------------------------------------   PRODUCT
				/*if( $e['PROPERTIES']['PRODUCT']['VALUE'] ):?>
					<div class="i_rse_product"></div>
				<?endif*/
					// ----------------------------------------------------------------------------------------------------   PRODUCT?>

				<?	// ----------------------------------------------------------------------------------------------------   NAME
				if( $e['DISPLAY_PROPERTIES']['MESSAGE']['DISPLAY_VALUE'] ):?>
					<div class="i_rse_message"><?=$e['DISPLAY_PROPERTIES']['MESSAGE']['DISPLAY_VALUE']?></div>
				<?endif
					// ----------------------------------------------------------------------------------------------------   NAME?>

			</div>
		<?endforeach?>
	</div>

	<?if($arParams['DISPLAY_BOTTOM_PAGER'] && $arResult['NAV_STRING'])
		echo '<br>'.$arResult['NAV_STRING'];
endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>