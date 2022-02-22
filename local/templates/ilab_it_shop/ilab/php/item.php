<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// Не хухры-мухры...
// ---------------------------------------------------------------------------------------------------- iLaB Item Functions
function i_showItem($APPLICATION, array $arOption = array(), $e, $arParams, array $prices_arr = array())
{

	global $USER;
	// IMG
	if( $e['I_PREVIEW_PICTURE']['src'] )
		$pick = $e['I_PREVIEW_PICTURE']['src'];
	elseif( $e['PREVIEW_PICTURE']['SRC'] )
		$pick = $e['PREVIEW_PICTURE']['SRC'];
	else {
		$pick = SITE_TEMPLATE_PATH . '/ilab/img/nophoto.png';
		$nophoto = true;
	}
	$pickClass = 'i_nophoto';

	if($arParams['I_STICKER'])
	{
		foreach ($arParams['I_STICKER'] as $ik => $ie) {
			if ($e['PROPERTIES'][$ie]['VALUE'])
				$stick = 'Y';
		}
	}
	?>

	<div class="i_item jq_item iprel" id="<?=$arOption['EDIT']?>">
		<div class="i_item_cont <?if($stick) echo 'with_stiker'?>">

			<!-- Стикер -->
			<?if( $e['I_STICKER'] ):?>
				<div class="i_item_stiker ipabs">
					<?$i=0;

					foreach($e['I_STICKER'] as $ie):

						if( $i>3 )
							continue;

						if( $e['PROPERTIES'][$ie]['VALUE']=='Y' ):?>
							<span class="i_item_stiker_<?=$ie?>">
								<?if( GetMessage($ie) )
									echo GetMessage($ie);
								else
									echo $e['PROPERTIES'][$ie]['NAME'];?>
							</span>
							<?$i++;
						elseif( $e['PROPERTIES'][$ie]['VALUE'] ):?>
							<span class="i_item_stiker_<?=$ie?>">
								<?=$e['PROPERTIES'][$ie]['VALUE']?>
							</span>
							<?$i++;
						endif;

					endforeach;

					if( in_array('I_DISCOUNT_DIFF_PERCENT', $e['I_STICKER'])  )
						echo '<span class="i_item_stiker_DIFF_PERCENT">- '.$e['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'].'%</span>'?>
				</div>
			<?endif?>
			<?// OLD Sticker
			/*if( $arParams['I_STICKER'] || ($e['MIN_PRICE']['DISCOUNT_VALUE'] < $e['MIN_PRICE']['VALUE']) ):?>
				<div class="i_item_stiker ipabs">
					<?if($arParams['I_STICKER'])
					{
						$i=0;foreach($arParams['I_STICKER'] as $ik=>$ie):
						if( $i<4 ):
							if( $e['PROPERTIES'][$ie]['VALUE']=='Y' ):?>
								<span class="i_item_stiker_<?=$ie?>">
									<?if( GetMessage($ie) )
										echo GetMessage($ie);
									else
										echo $e['PROPERTIES'][$ie]['NAME'];?>
								</span><br>
								<?$i++;elseif( $e['PROPERTIES'][$ie]['VALUE'] ):?>
								<span class="i_item_stiker_<?=$ie?>">
									<?=$e['PROPERTIES'][$ie]['VALUE']?>
								</span><br>
								<?$i++;endif;
						endif;
					endforeach;
					}
					if( $e['MIN_PRICE']['CAN_ACCESS'] && ($e['MIN_PRICE']['DISCOUNT_VALUE'] < $e['MIN_PRICE']['VALUE']) )
						echo '<span class="i_item_stiker_DIFF_PERCENT">- '.$e['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'].'%</span>'?>
				</div>
			<?endif*/?>
			<!-- Стикер -->

			<!-- Изображение -->
			  <? if($arParams['LAZY_LOAD'] == 'Y'): ?>
			    <a class="iprel swiper-lazy i_item_img <?if($nophoto) echo $pickClass?>" data-background="<?=$pick?>" <?/*style="background-image: url(<?=$pick?>)"*/?> href="<?=$e['DETAIL_PAGE_URL']?>">
				    <span class="swiper-lazy-preloader"></span>
			    </a>
			  <?else:?>
			    <a class="iprel i_item_img <?if($nophoto) echo $pickClass?>" style="background-image: url(<?=$pick?>)" href="<?=$e['DETAIL_PAGE_URL']?>">				</a>
			  <? endif; ?>
			<!-- Изображение -->

			<!-- Название -->
			<a class="i_item_name" href="<?=$e['DETAIL_PAGE_URL']?>"><?=$e['NAME']?></a>
			<!-- Название -->

			<!-- Характеристики/Описание -->
			<?if( $e['DISPLAY_PROPERTIES'] || $e['PREVIEW_TEXT'] && $arOption['FROM']!='MENU' ):?>
				<?if( $e['DISPLAY_PROPERTIES'] )://Описание?>
					<div class="i_dpro">
						<?$i=0;foreach($e['DISPLAY_PROPERTIES'] as $pro):
							if($i>7) continue?>

							<div class="i_dp_props">
								<div class="i_dp_name"><span><?=$pro['NAME']?></span></div>
								<div class="i_dp_val">
									<span>
									<?if( is_array($pro['VALUE']) )// Если множественный список
										foreach ($pro['VALUE'] as $ik=>$ipro)
										{
											if( $ik!=0 )
												echo ',&nbsp;';
											echo $ipro;
										}
									else// Одно значение
										echo $pro['VALUE'];?>
									</span>
								</div>
							</div>
							<?$i++;endforeach?>
					</div>
				<?elseif( $e['PREVIEW_TEXT'] )://Характеристики?>
					<div class="i_pre_txt"><?=$e['PREVIEW_TEXT']?></div>
				<?endif?>
			<?endif?>
			<!-- Характеристики/Описание -->

			<!-- Цена -->
			<div class="i_ebuy iprel">
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

						<span class="i_pr<?if( strlen($e['MIN_OFFER_PRICE'])>7 )echo ' ipfont7'?>"><span class="i_pr_from"><?=GetMessage('FROM')?> </span><?=$e['PRINT_MIN_OFFER_PRICE']?><?/*<span> / <?=$e['CATALOG_MEASURE_NAME']?></span>*/?></span>
					<?else:
						echo '<div class="i_noprice">'.GetMessage('I_NOPRICE').'</div>';
					endif?>
				</div>

				<div class="i_bb">
					<!-- Кнопка купить -->
					<?if( $e['I_TRADE_OFFERS'] ):?>
						<a href="<?=$e['DETAIL_PAGE_URL']?>" class="i_buy_buttom i_bdetail"><?=GetMessage('READ_MORE')?></a>
					<?elseif( $e['CATALOG_QUANTITY']>0 && $e['PRICES'] ):?>
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
							<div class="i_bs_close jq_bs_close ifont160 ipabs">&times;</div>
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
					<?if( !$e['I_TRADE_OFFERS'] && $e['CATALOG_QUANTITY']>0 ):?>
<!--						 Количество -->
                        <div class="i_count jq_count">
							<span class="i_co_minu jq_cop_minu"></span>
							<input class="i_co_numb jq_copnumb" type="text" value="<?=$e['CATALOG_MEASURE_RATIO']?>" jqmeasure="<?=$e['CATALOG_MEASURE_RATIO']?>">
							<span class="i_co_plus jq_cop_plus"></span>
						</div>
<!--                         Количество -->

					<?endif?>
				</div>
			</div>
			<!-- Цена -->
			<!-- Количество -->
			<?if( $arParams['I_CHECK_QUANTITY']=='Y' && $arParams['I_QUAN_VERY_LITTLE'] && $arParams['I_QUAN_LITTLE'] && $arParams['I_QUAN_AVERAGE'] ):?>
				<div class="i_quantity" title="<?=$e['I_QUAN_TEXT']?>">
					<span><span class="i_quan_sl
					<?if($e['I_QUAN_PERC'] <= $arParams['I_QUAN_VERY_LITTLE'] && $e['I_QUAN_PERC'] !== 0) {echo 'one_stack';}
						elseif($e['I_QUAN_PERC'] <= $arParams['I_QUAN_LITTLE'] && $e['I_QUAN_PERC'] > $arParams['I_QUAN_VERY_LITTLE']) {echo 'two_stack';}
						elseif($e['I_QUAN_PERC'] >= $arParams['I_QUAN_LITTLE'] && $e['I_QUAN_PERC'] <= $arParams['I_QUAN_AVERAGE']) {echo 'three_stack';}
						elseif($e['I_QUAN_PERC'] > $arParams['I_QUAN_AVERAGE']) {echo 'full_stack';} ?>">
						<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
							 viewBox="0 0 260 210" style="enable-background:new 0 0 260 210;" xml:space="preserve">
							<path class="st0" d="M220,0h30c5.5,0,10,4.5,10,10v190c0,5.5-4.5,10-10,10h-30c-5.5,0-10-4.5-10-10V10C210,4.5,214.5,0,220,0L220,0z"/>
							<path class="st1" d="M150,40h30c5.5,0,10,4.5,10,10v150c0,5.5-4.5,10-10,10h-30c-5.5,0-10-4.5-10-10V50C140,44.5,144.5,40,150,40L150,40z"/>
							<path class="st2" d="M80,80h30c5.5,0,10,4.5,10,10v110c0,5.5-4.5,10-10,10H80c-5.5,0-10-4.5-10-10V90C70,84.5,74.5,80,80,80L80,80z"/>
							<path class="st3" d="M10,120h30c5.5,0,10,4.5,10,10v70c0,5.5-4.5,10-10,10H10c-5.5,0-10-4.5-10-10v-70C0,124.5,4.5,120,10,120L10,120z"/>
						</svg>
						</span>
						<span class="i_quan_st"><?=$e['I_QUAN_TEXT']?></span>
					</span>
				</div>
			<?endif?>
			<!-- Количество -->
			<!-- Купить количество -->
			<?if( $arParams['I_SHOW_NUMBER']=='Y' && $e['CATALOG_QUANTITY']>0 ):?>
				<div class="i_disc_amount iprel">
					<?if( $e['I_TRADE_OFFERS'] ):?>
						<a class="i_datext_link" href="<?=$e['DETAIL_PAGE_URL']?>"><span>
						<?if( $e['PROPERTIES']['I_MULTI_PRICE']['VALUE']=='Y' )
							echo GetMessage('DISCOUNT_AMOUNT');
						else
							echo GetMessage('SELECT_NUMBER');?>
					</span></a>
					<?else:?>
						<?if( $e['PROPERTIES']['I_MULTI_PRICE']['VALUE']=='Y' ):?>
							<div class="i_datext jq_datext"><span><?=GetMessage('DISCOUNT_AMOUNT')?></span></div>
						<?else:?>
							<div class="i_datext_link jq_datext"><span><?=GetMessage('SELECT_NUMBER')?></span></div>
						<?endif?>

						<div class="i_mbuy jq_mbuy idnone ipabs jq_buy_count">
							<div class="i_mbuy_close jq_mbuy_close ipabs">×</div>
							<?if( $arParams['I_PRICE_MATRIX']=='Y' && $e['PRICE_MATRIX'] ):?>
								<?
								$params['PRICE_MATRIX']			= $e['PRICE_MATRIX'];
								$params['FIRST_MATRIX_ID']		= $e['ID'];
								$params['PRICE_MATRIX_OFFERS']	= $e['PRICE_MATRIX_OFFERS'];
								$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/mprice.php',$params,Array('MODE'=>'html', 'NAME'=>'Расчёт мультицен', 'SHOW_BORDER'=>false))// MULTI PRICE?>
								<?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/i_multi_buy.php',Array(),Array('MODE'=>'html', 'NAME'=>'Инфо мульти цен', 'SHOW_BORDER'=>false))// INFO MULTI PRICE?>
							<?endif?>
							<div class="i_mprice">
								<span class="i_mtotal"><?=GetMessage('TOTAL_PRICE')?></span><b class="i_mtnumb jq_mtnumb" jqmsum="<?=$e['MIN_PRICE']['DISCOUNT_VALUE']?>"><?=$e['MIN_PRICE']['PRINT_DISCOUNT_VALUE']?></b>
								<?if($e['MIN_PRICE']['DISCOUNT_DIFF_PERCENT']>0):?>
									<span class="i_mdisco"><?=GetMessage('DISCOUNT')?></span> <b class="i_mdnumb jq_mdnumb">-<?=$e['MIN_PRICE']['PRINT_DISCOUNT_DIFF']?></b>
								<?endif?>
							</div>
							<div class="i_count_text"><?=GetMessage('NUMBER_COMMODITY')?></div>
							<div class="i_count jq_count">
								<span class="i_co_minu jq_co_minu"></span>
								<input class="i_co_numb jq_conumb" type="text" value="<?=$e['CATALOG_MEASURE_RATIO']?>" jqmeasure="<?=$e['CATALOG_MEASURE_RATIO']?>">
								<span class="i_co_plus jq_co_plus"></span>
							</div>
							<div class="i_mbot iprel">
								<?/*if( array_key_exists($arParams['I_DEALER_PRICE'], $arResult['I_PRICES_GROUP'] ?? array()) ):// Дилер
								// Если нужно чтобы показывались у диллеров исключительно только диллерская цена.
								// В настройках компоненты - Символьный код оптовой цены(диллерская): указываем и работаем с ним
								if( $e['PRICES'][$arParams['I_DEALER_PRICE']] ):
									$de = preg_split('/\s(?=[^0-9])/', $e['PRICES'][$arParams['I_DEALER_PRICE']]['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.?>
									<span class="i_pr"><?=$de[0]?></span>&nbsp;<span class="i_tg"><?=$de[1]?></span>
								<?else:?>
									<div class="i_noprice">Дилерская цена.</div>
								<?endif?>

							<?else*/if( $e['MIN_PRICE'] && $e['MIN_PRICE']['CAN_ACCESS'] ):// Цена [MIN_PRICE]
									$pr = preg_split('/\s(?=[^0-9])/', $e['MIN_PRICE']['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.

									/*if ( $e['MIN_PRICE']['DISCOUNT_VALUE'] < $e['MIN_PRICE']['VALUE'] ):// Скидка?>
										<s class="i_pr_disc ipabs"><?=$e['MIN_PRICE']['PRINT_VALUE']?></s>
									<?elseif( $pr_max = i_price($e['PRICES'], $e['MIN_PRICE']['DISCOUNT_VALUE']) ):// или вычислим самую наибольшую цену?>
										<s class="i_pr_disc ipabs"><?=$e['PRICES'][$pr_max]['PRINT_VALUE']?></s>
									<?endif*/?>

									<span class="i_pr<?if( strlen($e['MIN_PRICE']['DISCOUNT_VALUE'])>9 )echo ' ipfont9'?>"><?=$pr[0]?></span>&nbsp;<span class="i_tg"><?=$pr[1]?></span>
								<?elseif( $e['PRINT_MIN_OFFER_PRICE'] ):?>
									<span class="i_pr<?if( strlen($e['MIN_OFFER_PRICE'])>7 )echo ' ipfont7'?>"><span class="i_pr_from"><?=GetMessage('FROM')?> </span><?=$e['PRINT_MIN_OFFER_PRICE']?></span>
								<?else:
									echo '<div class="i_noprice">Нет цены.</div>';
								endif?>

								<!-- Кнопка купить -->
								<?if($e['CAN_BUY']):?>
									<a href="<?=$e['BUY_URL']?>" class="i_buy_buttom jq_buy" jq_id="<?=$e['ID']?>" jqcount="<?=$e['CATALOG_MEASURE_RATIO']?>"><?=GetMessage('BUY')?></a>
									<a href="<?=SITE_DIR?>personal/basket.php" class="i_buy_bought jq_bought ipabs idnone"></a>
									<div class="i_buy_succes jq_buy_succes ipabs idnone" data-quan="<?=$e['CATALOG_QUANTITY']?>">
										<div class="i_bs_close jq_bs_close ifont160 ipabs">&times;</div>
										<span class="j_bask_succes idnone">
                                                <?=GetMessage('ADD_BASKET_SUCCES')?>
										</span>
										<span class="j_quan_miss idnone">
                                                <?=GetMessage('ADD_BASKET_MISS', Array ("#MEASURE#" => $e['CATALOG_MEASURE_NAME']))?>
										</span>
									</div>
								<?endif?>
								<!-- Кнопка купить -->
							</div>
						</div>
					<?endif?>
				</div>
			<?endif?>
			<!-- Купить количество -->

<?// -------------------------------------------------- Доп. элементы ?>
<?/*
		<div class="i_item_ext">
			<div class="i_compare_succes jq_compare_succes idn">
				<div class="i_bs_close jq_cs_close"></div>
				<?=GetMessage('COMPARE_SUCCES')?>
			</div>
			<a href="<?=$e['COMPARE_URL']?>" class="i_item_compare jq_item_compare" onclick="return i_Compare(this, '<?echo $e['ID'].'|'.$e['IBLOCK_ID']?>', '<?echo $e['DETAIL_PAGE_URL'].'†'.$pick.'†'.$e['NAME']?>')"><?=GetMessage('COMPARE')?></a>
			<a href="<?=$e['ADD_URL']?>" class="i_item_favorite jq_favorite" jq_id="<?=$e['ID']?>"><?=GetMessage('FAVORITES')?></a>
		</div>
*/?>
		<div class="i_item_ext">
	        <div class="i_compare_succes j_compare_success idnone" data-id="<?=$e['ID']?>">
	            <div class="i_compare_succes_div">

	                <div class="i_bs_close j_cs_close"></div>

	                <div class="j_me1"><?=GetMessage('COMPARE_ONE')?></div>
	                <div class="j_me2"><?=GetMessage('COMPARE_SUCCES')?></div>
	            </div>
	        </div>
			<div class="i_favorite_succes j_favorite_success idnone" data-id="<?=$arResult['ID']?>">
				<div class="i_favorite_succes_div">
					<div class="i_bs_close j_cs_close"></div>
					<div class="i_fv_succes_ms idnone"><?=GetMessage('FAVORITES_SUCCES')?></div>
					<div class="i_fv_error_ms idnone"><?=GetMessage('FAVORITES_ERROR')?></div>
				</div>
			</div>
	        <a href="<?=$e['COMPARE_URL']?>" class="i_item_compare j_item_compare" data-iblock_id="<?=$e['IBLOCK_ID']?>" data-id="<?=$e['ID']?>" data-change_text='{"txt_default":"<?=GetMessage('COMPARE')?>","txt_change":"<?=GetMessage('FROM_COMPARE')?>"}'>
	            <span><?=GetMessage('COMPARE')?></span>
	        </a>
	        <a href="<?=$e['ADD_URL']?>" class="i_item_favorite j_item_favorite" data-id="<?if(!$e['I_TRADE_OFFERS']) echo $e['ID']?>" jq_id="<?if(!$e['I_TRADE_OFFERS']) echo $e['ID']?>" data-change_text='{"txt_default":"<?=GetMessage('FAVORITES')?>","txt_change":"<?=GetMessage('FAVORITES_CHANGE')?>"}'>
	            <span><?=GetMessage('FAVORITES')?></span>
	        </a>
	    </div>
<?// -------------------------------------------------- Доп. элементы ?>
<?/* OLD
            <!-- Доп. элементы -->
            <div class="i_item_ext iprel">
                <div class="i_compare_succes j_compare_succes ipabs idnone">
                    <div class="i_compare_succes_div">
                        <div class="i_bs_close j_cs_close ipabs">&times;</div>
                        <div class="j_me1"><?=GetMessage('COMPARE_ONE')?></div>
                        <div class="j_me2"><?=GetMessage('COMPARE_SUCCES')?></div>
                    </div>
                </div>
                <div class="i_favorite_succes j_favorite_succes ipabs idnone">
                    <div class="i_favorite_succes_div iprel">
                        <div class="i_bs_close j_cs_close ipabs">&times;</div>
                        <div><?=GetMessage('FAVORITES_SUCCES')?></div>
                    </div>
                </div>
                <a href="<?=$e['COMPARE_URL']?>" class="i_item_compare jq_item_compare" data-iblock_id="<?=$e['IBLOCK_ID']?>" data-id="<?=$e['ID']?>" data-change_text='{"txt_default":"<?=GetMessage('COMPARE')?>","txt_change":"<?=GetMessage('FROM_COMPARE')?>"}'>
                    <span><?=GetMessage('COMPARE')?></span>
                </a>
                <a href="<?=$e['ADD_URL']?>" class="i_item_favorite jq_favorite" jq_id="<?=$e['ID']?>" data-change_text='{"txt_default":"<?=GetMessage('FAVORITES')?>","txt_change":"<?=GetMessage('FAVORITES_CHANGE')?>"}'>
                    <span><?=GetMessage('FAVORITES')?></span></a>
            </div>
            <!-- Доп. элементы -->
*/?>
		</div>
	</div>

<?}
// ---------------------------------------------------------------------------------------------------- iLaB?>
