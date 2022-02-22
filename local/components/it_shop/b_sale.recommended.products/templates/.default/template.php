<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$sw = $arParams['I_SWIPE']?>
	<div class="i_item_wrap i_mt25">
		<div class="jq_pagination_<?=$sw?> lt-pagination ipabs"></div>
		<a class="i_h2" href="/">
			<span><?=GetMessage($arParams['I_TITLE'])?></span>
		</a>
		<div class="i_sblock jq_sblock_<?=$sw?> swiper-container swiper-container-horizontal">
			<div class="swiper-wrapper">
				<?foreach($arResult['ITEMS'] as $k=>$e):
					$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
					$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
					<div class="swiper-slide">
						<?i_showItem($APPLICATION, array('I_BASE_CURRENCY'=>$arResult['I_BASE_CURRENCY'], 'EDIT'=>$this->GetEditAreaId($e['ID']), 'FROM'=>'CATALOG_SECTION'), $e, $arParams);// path of function - /local/templates/ilab_it_shop/ilab/php/item.php?>
					</div>
				<?endforeach?>
			</div>
		</div>
	</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>


<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>