<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Localization\Loc;
use Ilab\Core\Transform;

Loc::loadMessages(Bitrix\Main\Application::getDocumentRoot().SITE_TEMPLATE_PATH.'/header.php');

$l='ru';
//	---------------------------------------------------------------------------------------------------- iLaB PowereD
if( $arResult['ITEMS'] ):?>

	<!-- scrollBar -->
	<div class="ilab_c_pag_hor">
		<div class="ilab_c_characteristics_title"><?=Loc::getMessage('COMP_CHARACTERISTICS',false,$l);?></div>
		<div class="ilab_c_ph_left j_ph_left idnone"></div>
		<div class="ilab_c_ph_scroll j_ph_scroll"></div>
		<div class="ilab_c_ph_right j_ph_right idnone"></div>
	</div>
	<div class="ilab_c_pag_ver">
		<div class="ilab_c_pv_top j_pv_top idnone"></div>
		<div class="ilab_c_pv_scroll j_pv_scroll"></div>
		<div class="ilab_c_pv_bottom j_pv_bottom idnone"></div>
	</div>
	<!-- scrollBar -->

	<div class="swiper-container ilab_c_products j_products i_cs_tile"><div class="swiper-wrapper">
			<!-- Product -->
					<div class="swiper-slide ilab_c_pinfo j_pinfo">
						<div class="ilab_c_ct_product"><?=Loc::getMessage('COMP_PRODUCT',false,$l)?></div>
						<div class="ilab_c_ct_incompare"><?=Loc::getMessage('COMP_IN_COMPARE',false,$l)?></div>
						<div class="ilab_c_ct_count">
							<span class="j_comp_count" data-message='["<?=implode('","', Loc::getMessage('COMP_DEC_PRODUCT',false,$l))?>"]'>
								<?=i_declOfNum(count($arResult['ITEMS']), Loc::getMessage('COMP_DEC_PRODUCT',false,$l))?>
							</span>
							<span class="j_comp_cunit"></span>
						</div>
					</div>
				<?foreach($arResult['ITEMS'] as $k=>$e):?>
					<div class="swiper-slide ilab_c_item i_item jq_item">
						<div class="ilab_c_i_remove_compare j_remove_compare" data-id="<?=$e['ID']?>" data-iblock_id="<?=$e['IBLOCK_ID']?>"><span><?=Loc::getMessage('COMP_REMOVE',false,$l)?></span></div>
						<div class="ilab_c_i_block_compare">
							<a class="ilab_c_i_image swiper-lazy<?if(!$e['I_PICTURE'])echo ' ilab_c_i_nophoto'?>" href="<?=$e['DETAIL_PAGE_URL']?>"<?if($e['I_PICTURE'])echo ' style="background-image: url('.$e['I_PICTURE'].')"'?>></a>
							<div class="ilab_c_i_price i_item_price">


<?/*
if($arParams['I_PROP_PRICE_NAME'] == 'Y')
{
	$arGroups = $USER->GetUserGroupArray();
	if ($USER->IsAuthorized()) {
		foreach ($arGroups as $group) {
			if ($group == 5 || $group == 1) {
				$price_d = 'Дилерская';
				$price_r = 'Розничная';
			}
			//echo $group;
		}
	}
}*/?>
<div class="i_price <?if($pr_max = i_price($e['PRICES'], $e['MIN_PRICE']['DISCOUNT_VALUE'])) echo 'i_dealer'?>">
	<?if( array_key_exists($arParams['I_DEALER_PRICE'], $e['I_PRICES_GROUP'] ?? array()) ):// Дилер
	// Если нужно чтобы показывались у диллеров исключительно только диллерская цена.
	// В настройках компоненты - Символьный код оптовой цены(диллерская): указываем и работаем с ним
	if( $e['PRICES'][$arParams['I_DEALER_PRICE']] ):
		$de = preg_split('/\s(?=[^0-9])/', $e['PRICES'][$arParams['I_DEALER_PRICE']]['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.?>
		<span class="i_pr"><?=$de[0]?></span>&nbsp;<span class="i_tg"><?=$de[1]?></span>
	<?else:?>
		<div class="i_noprice">Дилерская цена.</div>
	<?endif?>
<?

	elseif( $e['MIN_PRICE'] && $e['MIN_PRICE']['CAN_ACCESS'] ):// Цена [MIN_PRICE]
		$pr = preg_split('/\s(?=[^0-9])/', $e['MIN_PRICE']['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.

		if ( $e['MIN_PRICE']['DISCOUNT_VALUE'] < $e['MIN_PRICE']['VALUE'] ):// Скидка?>
			<s class="i_pr_disc"><?=$e['MIN_PRICE']['PRINT_VALUE']?></s>
		<?elseif( $pr_max = i_price($e['PRICES'], $e['MIN_PRICE']['DISCOUNT_VALUE']) ):// или вычислим самую наибольшую цену?>
			<span class="i_pr_disc"><span><?//=i_price_text($prices_arr, $e['PRICES'][$pr_max])?></span> <span><?=$e['PRICES'][$pr_max]['PRINT_VALUE']?></span></span>
		<?endif?>

		<?if($pr_max):?><span class="i_pr_deal"><span> <?//=i_price_text($prices_arr, $e['MIN_PRICE'])?></span> <?endif;?><span class="i_pr<?if( strlen($e['MIN_PRICE']['DISCOUNT_VALUE'])>9 )echo ' ipfont9'?>"><?=$pr[0]?>&nbsp;<span class="i_tg"><?=$pr[1]?></span></span><?if($pr_max):?></span><?endif;?>
		<?/*<span class="i_measure"> / <?=$e['CATALOG_MEASURE_NAME']?></span>*/?>
	<?elseif( $e['PRINT_MIN_OFFER_PRICE'] ):?>
		<?// Максимальная цена [MAXIMUM_PRICE] v2.0
		if( $e['MIN_OFFER_PRICE']
			&& $arParams['I_MAX_PROP_PRICE']=='Y'
			&& $e['PROPERTIES']['MAXIMUM_PRICE']['VALUE']

			&& !$e['HIDE_MAX_OFFERS_PRICE'] ):?>
			<s class="i_pr_disc"><?=CurrencyFormat($e['PROPERTIES']['MAXIMUM_PRICE']['VALUE'], $arOption['I_BASE_CURRENCY'])?></s>
		<?endif?>

		<span class="i_pr_from"><?=GetMessage('FROM')?></span>&nbsp;<span class="i_pr<?if( strlen($e['MIN_OFFER_PRICE'])>7 )echo ' ipfont7'?>"><?=$e['PRINT_MIN_OFFER_PRICE']?></span>
		<span> / <?=$e['CATALOG_MEASURE_NAME']?></span>
	<?else:
		echo '<div class="i_noprice">'.GetMessage('I_NOPRICE').'</div>';
	endif?>
</div>

							</div>
							<div class="ilab_c_i_buy i_item_buy i_bb">

<?// -------------------------------------------------- Купить ?>
<!-- Кнопка купить -->
<?if( $e['I_TRADE_OFFERS'] ):?>
	<a href="<?=$e['DETAIL_PAGE_URL']?>" class="i_buy_buttom i_bdetail"><?=GetMessage('READ_MORE')?></a>
<?elseif( /*$e['CATALOG_QUANTITY']>0 && */$e['PRICES'] ):?>
	<a href="<?=$e['BUY_URL']?>" class="i_buy_buttom jq_buy" jq_id="<?=$e['ID']?>" jqcount="<?=$e['CATALOG_MEASURE_RATIO']?>"><?=GetMessage('BUY')?></a>
	<a href="<?=SITE_DIR?>personal/basket.php" class="i_buy_bought jq_bought ipabs idnone" jqbatxt="<?=GetMessage('IN_BASKET')?>:" jqbacount="<?=$e['CATALOG_MEASURE_RATIO']?>" jqbameasure="<?=$e['CATALOG_MEASURE_NAME']?>">
		<span>
			<span class="i_text"><?=GetMessage('IN_BASKET')?>:</span>
			<span class="i_m_ratio j_m_ratio"><?=$e['CATALOG_MEASURE_RATIO']?></span>
			<span class="i_m_name j_m_name"><?=$e['CATALOG_MEASURE_NAME']?></span>
		</span>
	</a>
	<div class="i_delete_item jq_delete_item idnone" jqid="<?//=$e['ID']?>"></div>
	<div class="i_buy_succes jq_buy_succes ipabs idnone" data-quan="<?=$e['CATALOG_QUANTITY']?>">
		<div class="i_bs_close jq_bs_close ifont160 ipabs"></div>
		<span class="j_bask_succes idnone">
			 <?=GetMessage('ADD_BASKET_SUCCES')?>
        </span>
		<span class="j_quan_miss idnone">
             <?=GetMessage('ADD_BASKET_MISS', Array ("#MEASURE#" => $e['CATALOG_MEASURE_NAME']))?>
        </span>
	</div>
<?elseif( $e['CATALOG_QUANTITY']<1 && $e['CATALOG_SUBSCRIBE']=='Y' ):?>
    <?/*<a class="i_buy_buttom ipabs i_sec_to_delay">*/?>
		<?global $APPLICATION;
        $APPLICATION->IncludeComponent('it_shop:b_catalog.product.subscribe','',
			array(
				'PRODUCT_ID' => $e['ID'],
				'BUTTON_ID' => $arParams['I_SWIPE'].$e['ID'],//$arItemIDs['SUBSCRIBE_LINK'],
				'BUTTON_CLASS' => 'bx_big bx_bt_button',
				//'DEFAULT_DISPLAY' => !$canBuy,
			),
			false, array('HIDE_ICONS' => 'Y')
		);?>
    <?/*</a>*/?>
<?elseif( $e['CATALOG_QUANTITY']<1 && $e['CATALOG_CAN_BUY_ZERO']=='Y' ):?>
    <a class="i_buy_buttom i_sec_to_order" href="<?=$e['DETAIL_PAGE_URL']?>"><?=GetMessage('TO_ORDER')?></a>
<?elseif( !$e['CAN_BUY'] ):?>
    <a href="<?=$e['DETAIL_PAGE_URL']?>" class="i_buy_buttom i_bdetail"><?=GetMessage('READ_MORE')?></a>
<?endif?>
<!-- Кнопка купить -->
<?if( !$e['I_TRADE_OFFERS']/* && $e['CATALOG_QUANTITY']>0 */):?>
	<!-- Количество -->
	<div class="i_count jq_count">
		<span class="i_co_minu jq_cop_minu"></span>
		<input class="i_co_numb jq_copnumb" type="text" value="<?=$e['CATALOG_MEASURE_RATIO']?>" jqmeasure="<?=$e['CATALOG_MEASURE_RATIO']?>">
		<span class="i_co_plus jq_cop_plus"></span>
	</div>
	<!-- Количество -->
<?endif?>
<?// -------------------------------------------------- Купить ?>
<?/*if( $e['I_TRADE_OFFERS'] ):?>
	<a href="<?=$e['DETAIL_PAGE_URL']?>" class="i_buy_buttom i_bdetail"><?=Loc::getMessage('READ_MORE',false,$l)?></a>
<?elseif( $e['CATALOG_QUANTITY']>0 && $e['PRICES'] ):?>
	<a href="<?=$e['BUY_URL']?>" class="i_buy_buttom jq_buy" jq_id="<?=$e['ID']?>" jqcount="<?=$e['CATALOG_MEASURE_RATIO']?>"><?=Loc::getMessage('BUY',false,$l)?></a>
	<a href="<?=SITE_DIR?>personal/basket.php" class="i_buy_bought jq_bought idnone" jqbatxt="<?=Loc::getMessage('IN_BASKET',false,$l)?>" jqbacount="<?=$e['CATALOG_MEASURE_RATIO']?>" jqbameasure="<?=$e['CATALOG_MEASURE_NAME']?>"></a>
	<div class="i_delete_item jq_delete_item idnone" jqid="<?//=$e['ID']?>"></div>
	<div class="i_buy_succes jq_buy_succes ipabs idnone">
		<div class="i_bs_close jq_bs_close ifont170 ipabs">&times;</div>
		<?=Loc::getMessage('ADD_BASKET_SUCCES',false,$l)?>
	</div>
<?elseif( $e['PRICES'] ):?>
	<a class="i_buy_buttom i_sec_to_order" href="<?=$e['DETAIL_PAGE_URL']?>"><?=Loc::getMessage('TO_ORDER',false,$l)?></a>
<?endif*/?>
<!-- Кнопка купить -->


							</div>
						</div>
						<a class="ilab_c_i_name" href="<?=$e['DETAIL_PAGE_URL']?>"><?=$e['NAME']?></a>
					</div>
				<?endforeach?>
			<!-- Product -->

			<!-- Property -->
				<div class="swiper-container ilab_c_property j_property"><div class="swiper-wrapper">
					<?if($arResult['I_PRO']):
						foreach($arResult['I_PRO'] as $nameProp=>$arProp):?>
							<div class="swiper-slide">

								<div class="ilab_c_prop_name"><?=$nameProp?></div>
								<?foreach($arProp as $pk=>$pv):?>
									<div class="ilab_c_prop_value j_prop_value" data-id="<?=$pk?>"><?
									if( is_array($pv) )// Если множественный список
											foreach ($pv as $ik=>$ipro)
												{
												if( $ik!=0 )
													echo ', ';
												echo $ipro;
											}
										else// Одно значение
											echo $pv;
									?></div>
								<?endforeach?>

							</div>
						<?endforeach;
					else:?>
						<div class="swiper-slide"><div class="ilab_c_prop_empty"><?=Loc::getMessage('COMP_CHARACTERISTICS_NO',false,$l)?></div></div>
					<?endif?>
				</div></div>
			<!-- Property -->
	</div></div>

<?endif
//	---------------------------------------------------------------------------------------------------- iLaB PowereD?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>