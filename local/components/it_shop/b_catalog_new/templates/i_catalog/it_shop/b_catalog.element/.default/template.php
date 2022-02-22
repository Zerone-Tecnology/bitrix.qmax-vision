<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):?>
<h1 class="i_h1_cele"><?=$arResult['NAME']?></h1>
<div class="i_cele ifont110">

	<!-- Картинки -->
	<div class="i_cele_img_block ifleft iprel">

		<a href="javascript:void(0)" class="i_cele_zoom ipabs"></a>
		<!-- Стикер -->
		<?if( $arParams['I_STICKER'] || ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] < $arResult['MIN_PRICE']['VALUE']) ):?>
			<div class="i_item_stiker ipabs">
				<?if($arParams['I_STICKER'])
				{
					$i=0;foreach($arParams['I_STICKER'] as $ik=>$ie):
						if($arResult['PROPERTIES'][$ie]['VALUE'] == 'Y' && $i++<4):?>
							<span class="i_item_stiker_<?=$ie?> ifont85">
								<?if( GetMessage($ie) )
									echo GetMessage($ie);
								else
									echo $arResult['PROPERTIES'][$ie]['NAME'];?>
							</span><br>
						<?endif;
					endforeach;
				}
				if( $arResult['MIN_PRICE']['CAN_ACCESS'] && ($arResult['MIN_PRICE']['DISCOUNT_VALUE'] < $arResult['MIN_PRICE']['VALUE']) )
					echo '<span class="i_item_stiker_DIFF_PERCENT">- '.$arResult['MIN_PRICE']['DISCOUNT_DIFF_PERCENT'].'%</span>'?>
			</div>
		<?endif?>
		<!-- Стикер -->

		<div class="jq_nophoto<?if( $arResult['MORE_PHOTO'] )echo ' idnone'?>">
			<div class="i_cele_nophoto"><img src="<?=SITE_TEMPLATE_PATH.'/ilab/img/nophoto.png'?>" alt="$arResult['NAME']" title="$arResult['NAME']"></div>
		</div>

		<?if( $arResult['MORE_PHOTO'] )://  idangerous.swiper?>
			<div class="i_cele_img_sw jq_cele_img_sw swiper-container ifleft<?if($arParams['I_SWIPER_AUTOPLAY']=='Y')echo ' jq_sw_auto'?>">
				<div class="swiper-wrapper">
					<?foreach ($arResult['MORE_PHOTO'] as $k=>$i):?>
						<div class="swiper-slide">
							<div class="i_cele_img">
								<a class="jq_fancybox" rel="fancybox-thumb" href="<?=$i['SRC']?>" title="<?=$arResult['NAME']?>"><?=CFile::ShowImage($i['SRC'], 380, 380, 'alt="'.$arResult['NAME'].'" title="'.$arResult['NAME'].'"')?></a>
							</div>
						</div>
					<?endforeach?>
				</div>
			</div>
		<?endif?>
			<div class="iclear"></div>

		<?if( $arResult['MORE_PHOTO'] ):// idangerous.swiper Nav?>
			<div class="i_cele_nav_img_block jq_cele_nav_img_block">
				<?foreach($arResult['MORE_PHOTO'] as $k=>$i):
					$reImage = CFile::ResizeImageGet($i, Array('width'=>100, 'height'=>100));
					if( $k == 0 )
						$unit_img = $reImage?>
					<a href="javascript:void(0)" class="i_cele_nav_img jq_cele_nav_img ifleft<?if($k == 0) echo ' i_cele_nav_act'?>" rel="<?=$k?>" alt="<?=$arResult['NAME']?>" title="<?=$arResult['NAME']?>">
						<div><img src="data:image/jpg;base64,<?=base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].$reImage['src']))?>"></div>
					</a>
				<?endforeach?>
			</div>
		<?endif?>

	</div>
	<!-- Картинки -->

	<div class="i_icard_rblock ifright iprel">
		<!-- SHARE -->
		<div class="i_cele_share ipabs">
			<span class="i_cele_sh_name ifont80"><?=GetMessage('SHARE')?></span>
			<noindex><div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir"></div></noindex>
			<script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
		</div>
		<div class="iclear"></div>
		<!-- SHARE -->
		<div class="i_icard_price">

			<!-- Цена -->
			<div class="icard_ebuy aclear">
				<!-- товар -->
				<div class="i_icard_price_block ifleft">
					<?/*if( array_key_exists($arParams['I_DEALER_PRICE'], $arResult['I_PRICES_GROUP'] ?? array()) ):// Дилер
						// Если нужно чтобы показывались у диллеров исключительно только диллерская цена.
						// В настройках компоненты - Символьный код оптовой цены(диллерская): указываем и работаем с ним
						if( $arResult['PRICES'][$arParams['I_DEALER_PRICE']] ):
							$de = preg_split('/\s(?=[^0-9])/', $arResult['PRICES'][$arParams['I_DEALER_PRICE']]['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.?>
							<span class="i_pr"><?=$de[0]?></span>&nbsp;<span class="icard_tg"><?=$de[1]?></span>
						<?else:?>
							<div class="i_noprice">Дилерская цена.</div>
						<?endif?>

					<?else*/if( $arResult['MIN_PRICE'] && $arResult['MIN_PRICE']['CAN_ACCESS'] ):// Цена [MIN_PRICE]
						$pr = preg_split('/\s(?=[^0-9])/', $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.

						if ( $arResult['MIN_PRICE']['DISCOUNT_VALUE'] < $arResult['MIN_PRICE']['VALUE'] ):// Скидка?>
							<span class="icard_pr_disc"><?echo GetMessage('OLD_PRICE').$arResult['MIN_PRICE']['PRINT_VALUE']?></span><br>
						<?elseif( $pr_max = i_price($arResult['PRICES'], $arResult['MIN_PRICE']['DISCOUNT_VALUE']) ):// или вычислим самую наибольшую цену?>
							<span class="icard_pr_disc"><?echo GetMessage('OLD_PRICE').$arResult['PRICES'][$pr_max]['PRINT_VALUE']?></span><br>
						<?endif?>

						<span class="icard_pr"><?=$pr[0]?></span>&nbsp;<span class="icard_tg"><?=$pr[1]?></span>
					<?else:
						echo '<div class="icard_noprice">Нет цены.</div>';
					endif?>
				</div>
				<!-- товар -->
				<!-- Кнопка купить -->
				<?if($arResult['CAN_BUY']):?>
					<div class="icard_buy">
						<div class="iprel">
							<a href="<?=$arResult['BUY_URL']?>" class="icard_buy_buttom jq_buy" jq_id="<?=$arResult['ID']?>"><?=GetMessage('BUY')?></a>
							<a href="<?=SITE_DIR?>personal/basket.php" class="icard_buy_bought jq_bought iprel idnone"></a>
							<div class="i_buy_succes jq_buy_succes ipabs idnone">
								<div class="i_bs_close jq_bs_close ifont160 ipabs">&times;</div>
								<?=GetMessage('ADD_BASKET_SUCCES')?>
							</div>
						</div>
					</div>
				<?endif?>
				<!-- Кнопка купить -->
			</div>
			<!-- Цена -->

			<!-- Количество -->
			<?if( $arParams['I_CHECK_QUANTITY']=='Y' && $arParams['I_QUAN_VERY_LITTLE'] && $arParams['I_QUAN_LITTLE'] && $arParams['I_QUAN_AVERAGE'] ):?>
				<div class="i_quantity aclear">
					<span class="i_quan_tx ifleft"><?=GetMessage('CATALOG_QUANTITY')?><span class="i_quan_sl"></span>&nbsp;<?=$arResult['I_QUAN_TEXT']?></span>
				</div>
			<?endif?>
			<!-- Количество -->

			<!-- Заказать по тел./Быстрый заказ -->
			<div class="i_check_block">

				<a href="javascript:void(0)" class="i_quick_order jq_quick_order ifleft" jq_item_name="<?=$arResult['NAME']?>" jq_item_id="<?=$arResult['IBLOCK_ID']?>|<?=$arResult['ID']?>"><span><?=GetMessage('QUICK_ORDER')?></span></a>
				<span class="i_cele_phone_block ifright">
					<span class="i_cele_phone ifont110">
						<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/item_phone.php',Array(),Array('MODE'=>'html', 'NAME'=>'Заказ по телефону', 'SHOW_BORDER'=>true))// Phone?>
					</span>
					<span class="ifont100"><?=GetMessage('ORDER_BY_PHONE')?></span>
				</span>
				<div class="iclear"></div>
			</div>
			<!-- Заказать по тел./Быстрый заказ -->
		</div>

		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/i_desc_prop.php',Array(),Array('MODE'=>'html', 'NAME'=>'Описание для характеристик', 'SHOW_BORDER'=>true));// Описание для характеристик?>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_stiker.php',Array(),Array('MODE'=>'html', 'NAME'=>'Стикеры в карточке', 'SHOW_BORDER'=>false));// Stiker?>

		<?if($arResult['DISPLAY_PROPERTIES'] || $arResult['PREVIEW_TEXT']):?>
			<div class="i_cele_detail_block">
				<!-- Описание -->
				<?if( $arResult['PREVIEW_TEXT'] ):?>
					<div class="i_cele_dtxt jq_dtxt">
						<div><?=$arResult['PREVIEW_TEXT']?></div>
					</div>
					<a class="i_cele_more_dtxt jq_more_dtxt jq_mored_show" href="javascript:void(0)"><?=GetMessage('MORE_TEXT')?></a>
					<a class="i_cele_more_dtxt jq_more_dtxt jq_mored_hide" style="display:none" href="javascript:void(0)"><?=GetMessage('MORE_TEXT_HIDE')?></a>
				<?endif?>
				<!-- Описание -->
				<!-- Характеристики -->
				<h3><?=GetMessage('FEATURES')?></h3>
				<div class="i_cele_property_block">
					<?foreach($arResult['DISPLAY_PROPERTIES'] as $pro):
						if( $с++ == $arParams['I_COUNT_PRO'] )echo '</div><div class="i_cele_property_block jq_cele_property_hide" style="display:none">'?>
						<div class="i_cele_property">
							<div class="i_w50per ifleft"><?=$pro['NAME']?></div>
							<div class="i_w50per ifleft">
								<?if( is_array($pro['VALUE']) )// Если множественный список
									foreach ($pro['VALUE'] as $ik=>$ipro)
										{
										if( $ik!=0 )
											echo ', ';
										echo $ipro;
									}
								else// Одно значение
									echo $pro['VALUE'];?>
							</div>
							<div class="iclear"></div>
						</div>
					<?endforeach?>
				</div>
				<a class="i_cele_more_features jq_more_features jq_moref_show" href="javascript:void(0)"><?=GetMessage('MORE_FEATURES')?></a>
				<a class="i_cele_more_features jq_more_features jq_moref_hide" style="display:none" href="javascript:void(0)"><?=GetMessage('MORE_FEATURES_HIDE')?></a>
				<!-- Характеристики -->
			</div>
		<?endif?>
	</div>
	<div class="iclear"></div>
	
	<div class="i_additional_info jq_additional_info iprel">
		<div class="i_ai_but_top jq_ai_but_top ipabs">
			<a class="i_ai_des jq_ai_but i_ai_but_act" jq_ai_but="1" href="javascript:void(0)"><span class="i_ai_name"><?=GetMessage('DESCRIPTION')?></span></a>
			<a class="i_ai_fea jq_ai_but" jq_ai_but="2" href="javascript:void(0)"><span class="i_ai_name"><?=GetMessage('FEATURES')?></span></a>
			<a class="i_ai_vid jq_ai_but" jq_ai_but="3" href="javascript:void(0)">
				<span class="i_ai_name"><?=GetMessage('VIDEO')?></span>
				<?if( $arResult['PROPERTIES']['I_VIDEO']['VALUE'] ):?>
					<span class="i_ai_count"><?=count( $arResult['PROPERTIES']['I_VIDEO']['VALUE'] )?></span>
				<?endif?>
			</a>
			<a class="i_ai_rev jq_ai_but jq_reviews_count" jq_ai_but="4" href="javascript:void(0)">
				<span class="i_ai_name"><?=GetMessage('REVIEWS')?></span>
				<?if( $arResult['I_REVIEWS'] ):?>
					<span class="i_ai_count jq_re_count"><?=count($arResult['I_REVIEWS'])?></span>
				<?endif?>
			</a>
			<a class="i_ai_ins jq_ai_but" jq_ai_but="5" href="javascript:void(0)">
				<span class="i_ai_name"><?=GetMessage('INSTRUCTION')?></span>
				<?if( $arResult['PROPERTIES']['I_INSTRUCTION']['VALUE'] ):?>
					<span class="i_ai_count"><?=count( $arResult['PROPERTIES']['I_INSTRUCTION']['VALUE'] )?></span>
				<?endif?>
			</a>
		</div>
		<div class="i_cele_content jq_ai_content">
			<div class="idnone" jq_ai_content="1" style="display:block">
				<?if( $arResult['DETAIL_TEXT'] )
					echo $arResult['DETAIL_TEXT'];
				else
					echo GetMessage('NOT_DETAIL_TEXT');?>
			</div>
			<div class="idnone" jq_ai_content="2">
				<?if($arResult['DISPLAY_PROPERTIES'])
					foreach ($arResult['DISPLAY_PROPERTIES'] as $pro):?>
						<div class="i_cele_property">
							<div class="i_w50per ifleft"><?=$pro['NAME']?></div>
							<div class="i_w50per ifleft">
								<?if( is_array($pro['VALUE']) )// Если множественный список
									foreach ($pro['VALUE'] as $ik=>$ipro)
										{
										if( $ik!=0 )
											echo ', ';
										echo $ipro;
									}
								else// Одно значение
									echo $pro['VALUE'];?>
							</div>
							<div class="iclear"></div>
						</div>
					<?endforeach;
				else
					echo GetMessage('NOT_PRO');?>
			</div>
			<div class="idnone" jq_ai_content="3">
				<?if( $arResult['PROPERTIES']['I_VIDEO']['I_VALUE'] )
					foreach ($arResult['PROPERTIES']['I_VIDEO']['I_VALUE'] as $k=>$v):
						if($k!=0)echo '<br><br>'?>
						<h2><?=$v['NAME']?></h2>
						<iframe width="100%" height="500" src="//www.youtube.com/embed/<?=$v['VIDEO']?>?rel=0&wmode=transparent" frameborder="0" allowfullscreen></iframe>
					<?endforeach;
				else
					echo GetMessage('NOT_VIDEO');?>
			</div>
			<div class="idnone" jq_ai_content="4">
				<a href="javascript:void(0)" class="i_add_review jq_add_review" jq_product_ajax="<?echo $arResult['ID'].'|'.$arResult['NAME']?>"><b><?=GetMessage('REVIEWS_ADD')?></b></a>
				<div class="i_reviews_block jq_reviews_block">

					<?if( $arResult['I_REVIEWS'] ):
						foreach($arResult['I_REVIEWS'] as $e):?>
							<div class="i_reviews_ele jq_reviews_ele_<?=$e['ID']?>">
								<div class="i_re_title"><b><?=$e['NAME']?></b>&nbsp;&nbsp;&nbsp;&nbsp;<i><?=$e['I_DATE_CREATE']?></i></div>
								<div class="i_re_text"><?=$e['DETAIL_TEXT']?></div>
								<?if($USER->isAdmin()):?>
									<div class="i_re_admin_panel">
										<small><a href="javascript:void(0)" class="jq_reviews_delete" jq_id="<?echo $e['IBLOCK_ID'].'|'.$e['ID']?>"><?=GetMessage('REVIEW_DETELE')?></a></small>
									</div>
								<?endif?>
							</div>
						<?endforeach;
					endif?>

				</div>
				<?//$APPLICATION->ShowViewContent('forum_topic_reviews')?>
			</div>
			<div class="idnone" jq_ai_content="5">
				<?if( $arResult['PROPERTIES']['I_INSTRUCTION']['VALUE'] ):
					foreach($arResult['PROPERTIES']['I_INSTRUCTION']['VALUE'] as $e):
						
					endforeach;
				else:
					echo GetMessage('NOT_INSTRUCTION');
				endif?>
			</div>
		</div>
		<div class="i_ai_bottom jq_ai_bottom ipabs">
			<a class="i_aib_but i_ai_des jq_ai_but i_ai_but_act" jq_ai_but="1" href="javascript:void(0)"><span class="i_ai_name"><?=GetMessage('DESCRIPTION')?></span></a>
			<a class="i_aib_but i_ai_fea jq_ai_but" jq_ai_but="2" href="javascript:void(0)"><span class="i_ai_name"><?=GetMessage('FEATURES')?></span></a>
			<a class="i_aib_but i_ai_vid jq_ai_but" jq_ai_but="3" href="javascript:void(0)"><span class="i_ai_name"><?=GetMessage('VIDEO')?></span></a>
			<a class="i_aib_but i_ai_rev jq_ai_but" jq_ai_but="4" href="javascript:void(0)"><span class="i_ai_name"><?=GetMessage('REVIEWS')?></span></a>

			<a class="i_ai_up jq_ai_up ipabs" href="javascript:void(0)"><span><?=GetMessage('UP')?></span></a>
		</div>
	</div>

	<!-- Блок продаж -->
	<table class="i_unit_sale iprel">
		<td class="i_us_img" valign="middle" align="center">
			<?if( $unit_img ):?>
				<img src="data:image/jpg;base64,<?=base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'].$unit_img['src']))?>" alt="<?=$arResult['NAME']?>" title="<?=$arResult['NAME']?>">
			<?else:?>
				<img src="<?=SITE_TEMPLATE_PATH.'/ilab/img/nophoto.png'?>" alt="<?=$arResult['NAME']?>" title="<?=$arResult['NAME']?>">
			<?endif?>
			<?//=CFile::ShowImage($arResult['MORE_PHOTO'][0]['SRC'], 100, 100, 'alt="'.$arResult['NAME'].'" title="'.$arResult['NAME'].'"')?>
		</td>
		<td class="i_us_name">
			<h3><?=$arResult['NAME']?></h3>
			<!-- Заказать по тел./Быстрый заказ -->
			<div class="i_check_block">
				<a href="javascript:void(0)" class="i_quick_order jq_unit_quick_order ifright" jq_item_name="<?=$arResult['NAME']?>" jq_item_id="<?=$arResult['IBLOCK_ID']?>|<?=$arResult['ID']?>"><span><?=GetMessage('QUICK_ORDER')?></span></a>
				<span class="i_cele_phone_block ifleft">
					<span class="i_cele_phone ifont110">
						<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/item_phone.php',Array(),Array('MODE'=>'html', 'NAME'=>'Заказ по телефону', 'SHOW_BORDER'=>false))// Phone?>
					</span>
					<?/*<span class="ifont100"><?=GetMessage('ORDER_BY_PHONE')?></span>*/?>
				</span>
				<div class="iclear"></div>
			</div>
			<!-- Заказать по тел./Быстрый заказ -->
		</td>
		<td class="i_us_price">
			<!-- Цена -->
			<div class="icard_ebuy aclear">
				<!-- товар -->
				<div class="i_icard_price_block ifleft">
					<?/*if( array_key_exists($arParams['I_DEALER_PRICE'], $arResult['I_PRICES_GROUP'] ?? array()) ):// Дилер
						// Если нужно чтобы показывались у диллеров исключительно только диллерская цена.
						// В настройках компоненты - Символьный код оптовой цены(диллерская): указываем и работаем с ним
						if( $arResult['PRICES'][$arParams['I_DEALER_PRICE']] ):
							$de = preg_split('/\s(?=[^0-9])/', $arResult['PRICES'][$arParams['I_DEALER_PRICE']]['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.?>
							<span class="i_pr"><?=$de[0]?></span>&nbsp;<span class="icard_tg"><?=$de[1]?></span>
						<?else:?>
							<div class="i_noprice">Дилерская цена.</div>
						<?endif?>

					<?else*/if( $arResult['MIN_PRICE'] && $arResult['MIN_PRICE']['CAN_ACCESS'] ):// Цена [MIN_PRICE]
						$pr = preg_split('/\s(?=[^0-9])/', $arResult['MIN_PRICE']['PRINT_DISCOUNT_VALUE']);// массивы вида [0]=>88 990,00 [1]=>тг.

						if ( $arResult['MIN_PRICE']['DISCOUNT_VALUE'] < $arResult['MIN_PRICE']['VALUE'] ):// Скидка?>
							<span class="icard_pr_disc"><?echo GetMessage('OLD_PRICE').$arResult['MIN_PRICE']['PRINT_VALUE']?></span><br>
						<?elseif( $pr_max = i_price($arResult['PRICES'], $arResult['MIN_PRICE']['DISCOUNT_VALUE']) ):// или вычислим самую наибольшую цену?>
							<span class="icard_pr_disc"><?echo GetMessage('OLD_PRICE').$arResult['PRICES'][$pr_max]['PRINT_VALUE']?></span><br>
						<?endif?>

						<span class="icard_pr"><?=$pr[0]?></span>&nbsp;<span class="icard_tg"><?=$pr[1]?></span>

					<?else:
						echo '<div class="icard_noprice">Нет цены.</div>';
					endif?>
				</div>
				<!-- товар -->
				<!-- Кнопка купить -->
				<?if($arResult['CAN_BUY']):?>
					<div class="icard_buy">
						<div class="iprel">
							<a href="<?=$arResult['BUY_URL']?>" class="icard_buy_buttom jq_buy" jq_id="<?=$arResult['ID']?>"><?=GetMessage('BUY')?></a>
							<a href="<?=SITE_DIR?>personal/basket.php" class="icard_buy_bought jq_bought iprel idnone"></a>
							<div class="i_buy_succes jq_buy_succes ipabs idnone">
								<div class="i_bs_close jq_bs_close ifont160 ipabs">&times;</div>
								<?=GetMessage('ADD_BASKET_SUCCES')?>
							</div>
						</div>
					</div>
				<?endif?>
				<!-- Кнопка купить -->
			</div>
			<!-- Цена -->
		</td>
	</table>
	<!-- Блок продаж -->

</div>
<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>
