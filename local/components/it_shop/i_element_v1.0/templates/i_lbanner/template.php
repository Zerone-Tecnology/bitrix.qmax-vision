<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):?>

	<div class="swiper-container i_lbanner<?if( count($arResult['ITEMS'])>1 ) echo ' jq_lbanner'?>">
		<div class="swiper-wrapper">
			<?foreach($arResult['ITEMS'] as $k=>$e):
				$this->AddEditAction($e['ID'], $e['EDIT_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT'));
				$this->AddDeleteAction($e['ID'], $e['DELETE_LINK'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE'), array('CONFIRM' => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));?>

				<div class="swiper-slide">
					<?if( $e['PRO']['I_LINK_'.$l]['VALUE'] )echo '<a href="'.$e['PRO']['I_LINK_'.$l]['VALUE'].'">'?>
						<img src="<?=$e['D_PRO']['I_BANNER_'.$l]['FILE_VALUE']['SRC']?>" alt="<?=$e['NAME']?>" title="<?=$e['NAME']?>" id="<?=$this->GetEditAreaId($e['ID'])?>">
					<?if( $e['PRO']['I_LINK_'.$l]['VALUE'] )echo '</a>'?>
				</div>

			<?endforeach?>
		</div>
		<?/*if( count($arResult['ITEMS'])>2 ):?>
			<div class="sw_nav_l jq_nav_rbanner_l ipabs"></div>
			<div class="sw_nav_r jq_nav_rbanner_r ipabs"></div>
		<?endif*/?>
	</div>
	<?//<div class="sw_pagination jq_pag_rbanner"></div>?>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>




<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>