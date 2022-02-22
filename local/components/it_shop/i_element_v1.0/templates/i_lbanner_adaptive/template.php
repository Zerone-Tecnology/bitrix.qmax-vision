<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>

	<div class="swiper-container i_lbanner<?if(count($arResult['ITEMS'])>1) echo ' jq_lbanner';?>">
		<div class="swiper-wrapper">
			<?foreach($arResult['ITEMS'] as $k=>$e):
				$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>
				<?
					$url1 = CFile::GetPath($e['PRO']['I_SM_BANNER_'.$l]['VALUE']);
					$url2 = CFile::GetPath($e['PRO']['I_MD_BANNER_'.$l]['VALUE']);
				?>
				<div class="swiper-slide">
					<a class="i_lbanner_img j_lbanner_img" href="<?= $e['PRO']['I_LINK_'.$l]['~VALUE']?>" style="display: block; background-image: url(<?=$url1?>)"
					   data-src1="<?=$url1?>" data-src2="<?=$url2?>"></a>
				</div>

			<?endforeach?>
		</div>
	</div>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>
