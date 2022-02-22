<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
echo ShowError($arResult["ERROR_MESSAGE"]);

$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
$bPriceType    = false;

if ($normalCount > 0):
	?>
	<div class="iprel" id="basket_items_list">
	<div class="bx_ordercart_order_table_container">
	<div id="basket_items">
		<div class="basket_items_head">
			<div class="basket_items_row">
				<?
				foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

				$arHeaders[] = $arHeader["id"];

				// remember which values should be shown not in the separate columns, but inside other columns
				if (in_array($arHeader["id"], array("TYPE")))
				{
					$bPriceType = true;
					continue;
				}
				elseif ($arHeader["id"] == "PROPS")
				{
					$bPropsColumn = true;
					continue;
				}
				elseif ($arHeader["id"] == "DELAY")
				{
					$bDelayColumn = true;
					continue;
				}
				elseif ($arHeader["id"] == "DELETE")
				{
					$bDeleteColumn = true;
					continue;
				}
				elseif ($arHeader["id"] == "WEIGHT")
				{
					$bWeightColumn = true;
				}

				if ($arHeader["id"] == "NAME"):
				?>
				<div class="item" colspan="3" id="col_<?=getColumnId($arHeader)?>">
					<?
					elseif ($arHeader["id"] == "PRICE"):
					?>
					<div class="price" id="col_<?=getColumnId($arHeader)?>">
						<?
						else:
						?>
						<div class="custom" id="col_<?=getColumnId($arHeader)?>">
							<?
							endif;
							?>
							<?=getColumnName($arHeader)?>
						</div>
						<?endforeach?>
					</div>
				</div>

				<div class="basket_items_body">
					<?
					foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

						if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):?>

							<div id="<?=$arItem["ID"]?>" class="jq_basket_item i_basket_item">

								<div class="i_basket_item_name">

								<?if ($bDelayColumn || $bDeleteColumn):?>
									<div class="i_bs_control">
										<?if ($bDeleteColumn):?>
											<a  class="i_bs_delete jq_bs_delete" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?//=GetMessage("SALE_DELETE")?></a>
										<?endif?>
									</div>
								<?endif;

								foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

									if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE"))) // some values are not shown in the columns in this template
										continue;

									if ($arHeader["id"] == "NAME"):?>

										<div class="itemphoto">

											<div class="bx_ordercart_photo_container">
												<?
												if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
													$url = $arItem["PREVIEW_PICTURE_SRC"];
												elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
													$url = $arItem["DETAIL_PICTURE_SRC"];
												else:
													$url = SITE_TEMPLATE_PATH."/ilab/img/nophoto.png";
												endif;
												?>

												<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
													<img src="<?=$url?>" class="bx_ordercart_photo">
													<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
											</div>

											<?if (!empty($arItem["BRAND"])):?>
												<div class="bx_ordercart_brand">
													<img alt="" src="<?=$arItem["BRAND"]?>" />
												</div>
											<?endif?>
										</div>
										<div class="item">
											<?if ($bDelayColumn):?>
												<a  class="i_bs_delay ifleft" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>" alt="<?=GetMessage('SALE_DELAY')?>" title="<?=GetMessage('SALE_DELAY')?>"><?//=GetMessage("SALE_DELAY")?></a>
											<?endif?>

											<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a class="bx_ordercart_itemtitle ifont115" href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
												<?=$arItem["NAME"]?>
												<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
											<div class="bx_ordercart_itemart">
												<?
												if ($bPropsColumn):
													foreach ($arItem["PROPS"] as $val):

														if (is_array($arItem["SKU_DATA"]))
														{
															$bSkip = false;
															foreach ($arItem["SKU_DATA"] as $propId => $arProp)
															{
																if ($arProp["CODE"] == $val["CODE"])
																{
																	$bSkip = true;
																	break;
																}
															}
															if ($bSkip)
																continue;
														}

														echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
													endforeach;
												endif;
												?>
											</div>
											<?/*
									if (is_array($arItem["SKU_DATA"]) && !empty($arItem["SKU_DATA"])):
										foreach ($arItem["SKU_DATA"] as $propId => $arProp):

											// if property contains images or values
											$isImgProperty = false;
											if (array_key_exists('VALUES', $arProp) && is_array($arProp["VALUES"]) && !empty($arProp["VALUES"]))
											{
												foreach ($arProp["VALUES"] as $id => $arVal)
												{
													if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
													{
														$isImgProperty = true;
														break;
													}
												}
											}

											$full = (count($arProp["VALUES"]) > 5) ? "full" : "";

											if ($isImgProperty): // iblock element relation property
											?>
												<div class="bx_item_detail_scu_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_scu_scroller_container">

														<div class="bx_scu">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=$arSkuValue["XML_ID"]?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);">
																			<span style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]?>)"></span>
																		</a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>

														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
													</div>

												</div>
											<?
											else:
											?>
												<div class="bx_item_detail_size_small_noadaptive <?=$full?>">

													<span class="bx_item_section_name_gray">
														<?=$arProp["NAME"]?>:
													</span>

													<div class="bx_size_scroller_container">
														<div class="bx_size">
															<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>"
																style="width: 200%; margin-left:0%;"
																class="sku_prop_list"
																>
																<?
																foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																	$selected = "";
																	foreach ($arItem["PROPS"] as $arItemProp):
																		if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																		{
																			if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																				$selected = "bx_active";
																		}
																	endforeach;
																?>
																	<li style="width:10%;"
																		class="sku_prop <?=$selected?>"
																		data-value-id="<?=$arSkuValue["NAME"]?>"
																		data-element="<?=$arItem["ID"]?>"
																		data-property="<?=$arProp["CODE"]?>"
																		>
																		<a href="javascript:void(0);"><?=$arSkuValue["NAME"]?></a>
																	</li>
																<?
																endforeach;
																?>
															</ul>
														</div>
														<div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
														<div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>);"></div>
													</div>

												</div>
											<?
											endif;
										endforeach;
									endif;
									*/?>

											<?if( $arItem['PROPS'] ):?>
												<div class="i_sku i_sku_basket">
													<ul class="aclear">
														<?foreach($arItem['PROPS'] as $e):?>
															<li class="ifleft<?if( file_exists($_SERVER['DOCUMENT_ROOT'].$e['VALUE']) )echo ' i_sku_color'?>"<?if( file_exists($_SERVER['DOCUMENT_ROOT'].$e['VALUE']) )echo ' style="background-image: url('.$e['VALUE'].')"'?>>
																<?if( !file_exists($_SERVER['DOCUMENT_ROOT'].$e['VALUE']) )
																	echo $e['VALUE']?>
															</li>
														<?endforeach?>
													</ul>
												</div>
											<?endif?>




											<?if($arResult['I_STATUS'][$arItem['I_SKU_LINK_ID']]):
												foreach($arResult['I_STATUS'][$arItem['I_SKU_LINK_ID']] as $e):?>
													<div class="i_delivery_condition">
														<div class="i_dc_col">
															<div class="i_dc_button jq_m_<?=toLower($e)?> i_c_<?=toLower($e)?>"><?=GetMessage('SALE_'.$e)?></div>
														</div>
														<div class="i_dc_col i_dc_link jq_m_<?=toLower($e)?>">
															<span class="i_dc_link_a"><?=GetMessage('SALE_TERMS', Array('#STATUS#'=>GetMessage('SALE_'.$e)))?></span>
														</div>
													</div>
												<?endforeach;
											endif?>

											<div class="iclear"></div>
										</div>
									</div>
										<?
									elseif ($arHeader["id"] == "QUANTITY"):
										?>
										<div class="custom">
											<span class="idnone"><?=getColumnName($arHeader)?>:</span>
											<?/*<div class="centered">
										<table cellspacing="0" cellpadding="0" class="counter">
											<tr>
												<td>*/?>
											<?
											$ratio = isset($arItem["MEASURE_RATIO"]) ? $arItem["MEASURE_RATIO"] : 0;
											$max = isset($arItem["AVAILABLE_QUANTITY"]) ? "max=\"".$arItem["AVAILABLE_QUANTITY"]."\"" : "";
											$useFloatQuantity = ($arParams["QUANTITY_FLOAT"] == "Y") ? true : false;
											$useFloatQuantityJS = ($useFloatQuantity ? "true" : "false");
											// MEASURE
											if (!isset($arItem["MEASURE_RATIO"]))
											{
												$arItem["MEASURE_RATIO"] = 1;
											}
											?>
											<div class="i_ba_count">
												<?if ( floatval($arItem["MEASURE_RATIO"]) != 0 ):?>
													<a href="javascript:void(0);" class="i_ba_minus ifleft" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"></a>
												<?endif?>
												<label for="QUANTITY_INPUT_<?=$arItem["ID"]?>" class="i_ba_change_mp_d ifleft"<?if(isset($arItem["MEASURE_TEXT"]))echo ' cssmeasure="'.$arItem["MEASURE_TEXT"].'"'?>>
													<input
														class="i_ba_change_mp"
														type="text"
														size="3"
														id="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														name="QUANTITY_INPUT_<?=$arItem["ID"]?>"
														size="2"
														maxlength="18"
														min="0"
														<?=$max?>
														step="<?=$ratio?>"
														style="max-width: 50px"
														value="<?=$arItem["QUANTITY"]?>"
														onchange="updateQuantity('QUANTITY_INPUT_<?=$arItem["ID"]?>', '<?=$arItem["ID"]?>', <?=$ratio?>, <?=$useFloatQuantityJS?>)"
														>
												</label>
												<?//</td>*/?>
												<?if ( floatval($arItem["MEASURE_RATIO"]) != 0 ):?>
													<a href="javascript:void(0);" class="i_ba_plus ifleft" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"></a>
												<?endif?>
											</div>
											<?/*if (isset($arItem["MEASURE_TEXT"]))
												{
													?>
														<?//<td style="text-align: left">?><span style="display: block;"><?=$arItem["MEASURE_TEXT"]?></span><?//</td>?>
													<?
												}
												*/?>
											<?/*if ( floatval($arItem["MEASURE_RATIO"]) != 0 ):?>
													<?//<td id="basket_quantity_control">?>
														<div class="basket_quantity_control">
															<a href="javascript:void(0);" class="plus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'up', <?=$useFloatQuantityJS?>);"></a>
															<a href="javascript:void(0);" class="minus" onclick="setQuantity(<?=$arItem["ID"]?>, <?=$arItem["MEASURE_RATIO"]?>, 'down', <?=$useFloatQuantityJS?>);"></a>
														</div>
													<?//</td>?>
												<?endif*/?>

											<?/*</tr>
										</table>
									</div>*/?>
											<?
											echo getMobileQuantityControl(
												"QUANTITY_SELECT_".$arItem["ID"],
												"QUANTITY_SELECT_".$arItem["ID"],
												$arItem["QUANTITY"],
												$arItem["AVAILABLE_QUANTITY"],
												$useFloatQuantityJS,
												$arItem["MEASURE_RATIO"],
												$arItem["MEASURE_TEXT"]
											);
											?>
											<input type="hidden" id="QUANTITY_<?=$arItem['ID']?>" name="QUANTITY_<?=$arItem['ID']?>" value="<?=$arItem["QUANTITY"]?>" />
										</div>
										<?
									elseif ($arHeader["id"] == "PRICE"):
										?>
										<div class="price">
											<div class="current_price ifont115 i_measure" id="current_price_<?=$arItem["ID"]?>" jqmeasure="/ <?=$arItem["MEASURE_TEXT"]?>"><?=$arItem["PRICE_FORMATED"]?></div>
											<div class="old_price" id="old_price_<?=$arItem["ID"]?>">
												<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
													<?=$arItem["FULL_PRICE_FORMATED"]?>
												<?endif;?>
											</div>

											<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
												<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
												<div class="type_price_value"><?=$arItem["NOTES"]?></div>
											<?endif;?>
										</div>
										<?
									elseif ($arHeader["id"] == "DISCOUNT"):
										?>
										<div class="custom custom_discount">
											<span class="idnone"><?=getColumnName($arHeader)?>:</span>
											<div id="discount_value_<?=$arItem["ID"]?>" class="ifont120"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
										</div>
										<?
									elseif ($arHeader["id"] == "WEIGHT"):
										?>
										<div class="custom">
											<span class="idnone"><?=getColumnName($arHeader)?>:</span>
											<?=$arItem["WEIGHT_FORMATED"]?>
										</div>
										<?
									else:
										?>
										<div class="custom">
											<span class="idnone"><?=getColumnName($arHeader)?>:</span>
											<?
											if ($arHeader["id"] == "SUM"):
											?>
											<div id="sum_<?=$arItem["ID"]?>" class="current_price ifont115">
												<?
												endif;

												echo $arItem[$arHeader["id"]];

												if ($arHeader["id"] == "SUM"):
												?>
											</div>
										<?
										endif;
										?>
										</div>
										<?
									endif;
								endforeach;?>
							</div>
						<?endif;
					endforeach;
					?>
				</div>
			</div>
		</div>
		<input type="hidden" id="column_headers" value="<?=CUtil::JSEscape(implode($arHeaders, ","))?>" />
		<input type="hidden" id="offers_props" value="<?=CUtil::JSEscape(implode($arParams["OFFERS_PROPS"], ","))?>" />
		<input type="hidden" id="action_var" value="<?=CUtil::JSEscape($arParams["ACTION_VARIABLE"])?>" />
		<input type="hidden" id="quantity_float" value="<?=$arParams["QUANTITY_FLOAT"]?>" />
		<input type="hidden" id="count_discount_4_all_quantity" value="<?=($arParams["COUNT_DISCOUNT_4_ALL_QUANTITY"] == "Y") ? "Y" : "N"?>" />
		<input type="hidden" id="price_vat_show_value" value="<?=($arParams["PRICE_VAT_SHOW_VALUE"] == "Y") ? "Y" : "N"?>" />
		<input type="hidden" id="hide_coupon" value="<?=($arParams["HIDE_COUPON"] == "Y") ? "Y" : "N"?>" />
		<input type="hidden" id="coupon_approved" value="N" />
		<input type="hidden" id="use_prepayment" value="<?=($arParams["USE_PREPAYMENT"] == "Y") ? "Y" : "N"?>" />

		<div class="bx_ordercart_order_pay">

			<div class="bx_ordercart_order_pay_left">
				<div class="bx_ordercart_coupon iprel">
					<div class="i_ordercart_coupon">
						<?
						if ($arParams["HIDE_COUPON"] != "Y"):

							$couponClass = "";
							if (array_key_exists('COUPON_VALID', $arResult))
							{
								$couponClass = ($arResult["COUPON_VALID"] == "Y") ? "good" : "bad";
							}elseif (array_key_exists('COUPON', $arResult) && strlen($arResult["COUPON"]) > 0)
							{
								$couponClass = "good";
							}

							?>
							<span><?=GetMessage("STB_COUPON_PROMT")?></span>
							<input type="text" id="coupon" name="COUPON" value="<?=$arResult["COUPON"]?>" onchange="enterCoupon();" size="21" class="<?=$couponClass?>" style="width: 300px">
						<?else:?>
							&nbsp;
						<?endif;?>
					</div>

					<?if( CSite::InDir(SITE_DIR.'personal/basket.php') ):?>
						<div class="i_ba_buttom ipabs">
							<a class="i_ba_fpay jq_ba_fpay" href="javascript:void(0)"<?if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo ' jq_basket="Y"'?>><span><?=GetMessage('FORMD_PAYMENT')?></span></a>
							<a class="i_ba_dmet jq_ba_dmet" href="javascript:void(0)"<?if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo ' jq_basket="Y"'?>><span><?=GetMessage('DELIVERY_METHODS')?></span></a>
						</div>
					<?endif?>

				</div>
			</div>

			<div class="bx_ordercart_order_pay_right">
				<div class="bx_ordercart_order_sum iwauto ifright">
					<div class="bx_ordercart_order_sum_div">
						<?if ($bWeightColumn):?>
							<div class="custom_t1"><?=GetMessage("SALE_TOTAL_WEIGHT")?></div>
							<div class="custom_t2" id="allWeight_FORMATED"><?=$arResult["allWeight_FORMATED"]?></div>
						<?endif?>
						<?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
							<div class="custom_t1 padleft">Цена без скидки:</div>
							<div class="custom_t2" style="text-decoration:line-through; color:#828282;" id="PRICE_WITHOUT_DISCOUNT">
								<?=$arResult["PRICE_WITHOUT_DISCOUNT"]?>
							</div>
						<?endif?>
						<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
							<div class="bx_ordercart_order_sum_row">
								<div class="padleft"><?=GetMessage('SALE_VAT_EXCLUDED')?></div>
								<div id="allSum_wVAT_FORMATED" class="ifont115"><?=$arResult["allSum_wVAT_FORMATED"]?></div>
							</div>
							<div class="bx_ordercart_order_sum_row">
								<div class="padleft"><?=GetMessage('SALE_VAT_INCLUDED')?></div>
								<div id="allVATSum_FORMATED" class="ifont115"><?=$arResult["allVATSum_FORMATED"]?></div>
							</div>
						<?endif?>
						<div class="bx_ordercart_order_sum_row">
							<div class="padleft"><?=GetMessage("SALE_TOTAL")?></div>
							<div class="fwb" id="allSum_FORMATED"><?=str_replace(" ", "&nbsp;", $arResult["allSum_FORMATED"])?></div>
						</div>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div style="clear:both"></div>

			<?if( $arParams['STEAKER_STATUS']=='Y' && $arResult['I_STATUS']):?>
				<div class="i_ba_steaker_status iprel">

					<div class="i_ba_m_steaker_status jq_ba_m_steaker_status idnone ipabs">
						<div class="i_bs_close jq_ba_ss_close ifont170 ipabs">×</div>
						<?=GetMessage('SALE_STEAKER_STATUS')?>
					</div>

					<input class="i_ba_ss_check jq_ba_ss_check" type="checkbox" id="steaker_status" style="margin: 1px 5px 0px 0px;">

					<label for="steaker_status">
						<?=GetMessage('SALE_I_AGREE');
						foreach($arResult['I_FINAL_STATUS'] as $k=>$e):
							if($k>0)
								echo GetMessage('SALE_I_AND')?>
							<div class="i_dc_col i_dc_link jq_<?=toLower($e)?>">
								<span class="i_dc_link_a"><?=GetMessage('SALE_TERMS_CHECK', Array('#STATUS#' => GetMessage('SALE_'.$e)))?></span>
							</div>
						<?endforeach?>
					</label>

				</div>
			<?endif?>

			<?if( $arParams['TERMS_OF_USE']=='Y' ):?>
				<div class="iprel" align="center">
					<div class="jq_ba_terms_of_use i_ba_terms_of_use idnone ipabs">
						<div class="i_bs_close jq_bat_close ifont170 ipabs">×</div>
						<?=GetMessage('TERMS_OF_USE')?>
					</div>
					<input class="jq_bai_terms_of_use" type="checkbox" id="terms_of_use" style="margin: 1px 5px 0px 0px;"><label for="terms_of_use"><?=GetMessage('TERMS_OF_USE_1')?></label> <a target="_blank" href="<?=SITE_DIR?>polzovatelskoe_soglashenie/"><?=GetMessage('TERMS_OF_USE_2')?></a> <?=GetMessage('TERMS_OF_USE_3')?>
				</div>
			<?endif?>

			<div class="bx_ordercart_order_pay_center<?if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo ' italign_c'?> place_order_div iprel aclear">

				<?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
					<?=$arResult["PREPAY_BUTTON"]?>
					<span><?=GetMessage("SALE_OR")?></span>
				<?endif;
				$limit_order	= $arParams['I_MIN_PUTCHASE_AMOUNT'] && $arResult['allSum']<=$arParams['I_MIN_PUTCHASE_AMOUNT'];?>

				<a href="javascript:void(0)" onclick="<?if( !$limit_order )echo 'checkOut();'?>" class="checkout i_place_order i_but_ac ifont130 jq_checkout<?if( CSite::InDir(SITE_DIR.'personal/basket/index.php') )echo ' ifright';if( $limit_order )echo ' i_checkout_inactive';?>" jqsum="<?=$arParams['I_MIN_PUTCHASE_AMOUNT']?>"<?if($arParams['I_MIN_PUTCHASE_AMOUNT'])echo ' jq_chec_act="Y"'?>><?=GetMessage("SALE_ORDER")?></a>
				<div class="i_chec_modal jq_chec_modal jq_buy_modal idnone ipabs">
					<div class="i_bs_close jq_bs_close ifont170 ipabs">×</div>
					<span style="color:#FF0000"><?=GetMessage('LIMIT_NOTE_1').CurrencyFormat($arParams['I_MIN_PUTCHASE_AMOUNT'], 'KZT').GetMessage('LIMIT_NOTE_2')?></span>
				</div>
			</div>
		</div>

		<?if( CSite::InDir(SITE_DIR.'personal/basket/index.php') ):?>
			<div class="i_ba_buttom ipabs">
				<a class="i_ba_fpay jq_ba_fpay" href="javascript:void(0)"<?//if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo ' jq_basket="Y"'?>><span><?=GetMessage('FORMD_PAYMENT')?></span></a>
				<a class="i_ba_dmet jq_ba_dmet" href="javascript:void(0)"<?//if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo ' jq_basket="Y"'?>><span><?=GetMessage('DELIVERY_METHODS')?></span></a>
			</div>
		<?endif?>

	</div>
	<div id="basket_items_list" class="jqba_bask_last idnone">
		<div class="i_empty_basket">
			<?//ShowError($arResult["ERROR_MESSAGE"])?>
			<?=GetMessage('EMPTY_BASKET')?>&nbsp;<a href="<?=SITE_DIR?>" class="i_but_ac"><?=GetMessage('START_BUY')?></a>
		</div>
	</div>
	<?
else:
	?>
	<div id="basket_items_list">
		<div class="i_empty_basket">
			<?//ShowError($arResult["ERROR_MESSAGE"])?>
			<?=GetMessage('EMPTY_BASKET')?>&nbsp;<a href="<?=SITE_DIR?>" class="i_but_ac"><?=GetMessage('START_BUY')?></a>
		</div>
	</div>
	<?/*
<div id="basket_items_list">
	<table>
		<tbody>
			<tr>
				<td colspan="<?=$numCells?>" style="text-align:center">
					<div class=""><?=GetMessage("SALE_NO_ITEMS");?></div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
*/?>
	<?
endif;
?>



<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>