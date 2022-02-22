<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
//	---------------------------------------------------------------------------------------------------- iLaB PowereD
if( $arResult['ITEMS'] ):?>

	<!-- scrollBar -->
	<div class="ilab_pag_hor">
		<div class="ilab_ct_characteristics"><?=Loc::getMessage('COMP_CHARACTERISTICS');?></div>
		<div class="ilab_ph_left j_ph_left idnone"></div>
		<div class="ilab_ph_scroll j_ph_scroll"></div>
		<div class="ilab_ph_right j_ph_right idnone"></div>
	</div>
	<div class="ilab_pag_ver">
		<div class="ilab_pv_top j_pv_top idnone"></div>
		<div class="ilab_pv_scroll j_pv_scroll"></div>
		<div class="ilab_pv_bottom j_pv_bottom idnone"></div>
	</div>
	<!-- scrollBar -->

	<div class="swiper-container ilab_products j_products"><div class="swiper-wrapper">
			<!-- Product -->
					<div class="swiper-slide"><div class="ilab_pinfo j_pinfo">
						<div class="ilab_ct_product"><?=Loc::getMessage('COMP_PRODUCT')?></div>
						<div class="ilab_ct_incompare"><?=Loc::getMessage('COMP_IN_COMPARE')?></div>
						<div class="ilab_ct_count">
							<span class="j_comp_count" data-message='["<?=implode('","', Loc::getMessage('COMP_DEC_PRODUCT'))?>"]'>
								<?=i_declOfNum(count($arResult['ITEMS']), Loc::getMessage('COMP_DEC_PRODUCT'))?>
							</span>
						</div>
					</div></div>
				<?foreach($arResult['ITEMS'] as $k=>$e):?>
					<div class="swiper-slide"><div class="ilab_pitem">
						<div class="ilab_i_remove_compare j_remove_compare" data-id="<?=$e['ID']?>" data-iblock_id="<?=$e['IBLOCK_ID']?>"><span><?=Loc::getMessage('COMP_REMOVE')?></span></div>
						<div class="aclear iprel">
							<a class="ilab_i_image ifleft" href="<?=$e['DETAIL_PAGE_URL']?>" style="background-image: url(<?=$e['I_PICTURE']?>)"></a>
							<div class="ilab_i_price">


<!-- Кнопка купить -->
<!-- Кнопка купить -->


							</div>
							<div class="ilab_i_buy">


<!-- Кнопка купить -->
<!-- Кнопка купить -->


							</div>
						</div>
						<a class="ilab_i_name" href="<?=$e['DETAIL_PAGE_URL']?>"><?=$e['NAME']?></a>
					</div></div>
				<?endforeach?>
			<!-- Product -->
				<div class="iclear"></div>
			<!-- Property -->
				<div class="swiper-container ilab_property j_property"><div class="swiper-wrapper">
					<?if($arResult['I_PRO']):
						foreach($arResult['I_PRO'] as $nameProp=>$arProp):?>
							<div class="swiper-slide">

								<div class="ilab_prop_name"><?=$nameProp?></div>
								<?foreach($arProp as $pk=>$pv):?>
									<div class="ilab_prop_value j_prop_value" data-id="<?=$pk?>"><?=$pv?></div>
								<?endforeach?>

							</div>
						<?endforeach;
					else:?>
						<div class="swiper-slide"><div class="ilab_prop_empty"><?=Loc::getMessage('COMP_CHARACTERISTICS_NO')?></div></div>
					<?endif?>
				</div></div>
			<!-- Property -->
	</div></div>

<?endif
//	---------------------------------------------------------------------------------------------------- iLaB PowereD?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
