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
			<table id="basket_items">
				<thead>
				<tr>
					<td>
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
							<div class="basket_items_col item col_<?=getColumnId($arHeader)?>" colspan="3" id="col_<?=getColumnId($arHeader)?>">
								<?
								elseif ($arHeader["id"] == "PRICE"):
								?>
								<div class="basket_items_col price col_<?=getColumnId($arHeader)?>" id="col_<?=getColumnId($arHeader)?>">
									<?
									else:
									?>
									<div class="basket_items_col custom col_<?=getColumnId($arHeader)?>" id="col_<?=getColumnId($arHeader)?>">
										<?
										endif;
										?>
										<?=getColumnName($arHeader)?>
									</div>
									<?endforeach?>
					</td>
				</tr>
				</thead>

				<tbody>
				<?
				foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

					if ($arItem["DELAY"] == "N" && $arItem["CAN_BUY"] == "Y"):?>

						<?
						$price_clean = i_price_currency_division($arItem["PRICE_FORMATED"]);/*----------------------удаление тг*/
						$full_price_clean = i_price_currency_division($arItem["FULL_PRICE_FORMATED"]);
						?>

						<tr id="<?=$arItem["ID"]?>" class="jq_basket_item">
							<td>
                                <div class="i_b_item_top_bl">
									<?
									if ($bDelayColumn):
										?>
                                        <a class="i_bs_delay" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?//=GetMessage("SALE_DELAY")?></a>
										<?
									endif;
									?>
                                    <div class="bx_ordercart_itemtitle">
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<?=$arItem["NAME"]?>
											<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                    </div>
                                </div>
                                <div class="i_b_item_bl">
									<?
									foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

									if ($skipHeaders && in_array($arHeader["id"], $skipHeaders)) // some values are not shown in the columns in this template
										continue;

									if ($arHeader["name"] == '')
										$arHeader["name"] = GetMessage("SALE_".$arHeader["id"]);

									if ($arHeader["id"] == "NAME"):
										?>
                                        <div class="item col_<?=$arHeader['id']?>">
											<?
											if ($bDeleteColumn):
												?>
                                                <a class="i_bs_delete jq_bs_delete" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"
													<?/*onclick="return deleteProductRow(this)"*/?>>
													<?//=GetMessage("SALE_DELETE")?>
                                                </a>
												<?
											endif;
											?>
                                            <div class="itemphoto">
                                                <div class="bx_ordercart_photo_container">
													<?
													if (strlen($arItem["PREVIEW_PICTURE_SRC"]) > 0):
														$url = $arItem["PREVIEW_PICTURE_SRC"];
                                                    elseif (strlen($arItem["DETAIL_PICTURE_SRC"]) > 0):
														$url = $arItem["DETAIL_PICTURE_SRC"];
													else:
														$ini_s = ' ini_s';
														$url = '';//SITE_TEMPLATE_PATH."/ilab/img/ini_s.png";
													endif;

													if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
                                                        <div class="bx_ordercart_photo<?=$ini_s;unset($ini_s)?>"<?if( $url )echo ' style="background-image:url('.$url.')"'?>></div>
														<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                                </div>
												<?
												if (!empty($arItem["BRAND"])):
													?>
                                                    <div class="bx_ordercart_brand">
                                                        <img alt="" src="<?=$arItem["BRAND"]?>" />
                                                    </div>
													<?
												endif;
												?>
                                            </div>
                                            <div class="bx_ordercart_itemtitle">
												<?
												if ($bDelayColumn):
													?>
                                                    <a class="i_bs_delay" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delay"])?>"><?//=GetMessage("SALE_DELAY")?></a>
													<?
												endif;
												?>
												<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
													<?=$arItem["NAME"]?>
													<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                            </div>
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

														echo htmlspecialcharsbx($val["NAME"]).":&nbsp;<span>".$val["VALUE"]."</span><br/>";
													endforeach;
												endif;
												?>
                                            </div>
											<?if( $arItem['PROPS'] ):?>
                                                <div class="i_sku i_sku_basket">
                                                    <ul class="aclear">
														<?foreach($arItem['PROPS'] as $e):?>
                                                            <li class="ifleft<?if( is_file($_SERVER['DOCUMENT_ROOT'].$e['VALUE']) )echo ' i_sku_color'?>"<?if( is_file($_SERVER['DOCUMENT_ROOT'].$e['VALUE']) )echo ' style="background-image: url('.$e['VALUE'].')"'?>>
																<?if( !is_file($_SERVER['DOCUMENT_ROOT'].$e['VALUE']) )
																	echo $e['NAME']?>
                                                            </li>
														<?endforeach?>
                                                    </ul>
                                                </div>
											<?endif?>
                                        </div>
										<?
                                    elseif ($arHeader["id"] == "QUANTITY"):
										?>
                                        <div class="custom col_<?=$arHeader['id']?>">
                                            <span><?=getColumnName($arHeader)?>:</span>
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
                                            <div class="centered ">
                                                <div class="basket_quantity_control i_ba_count">
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
												<?if (isset($arItem["MEASURE_TEXT"]))
												{
													?>
													<?//<td style="text-align: left">?><span style="display: block;"><?=$arItem["MEASURE_TEXT"]?></span><?//</td>?>
													<?
												}
												?>
                                            </div>
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
												1,//$arItem["AVAILABLE_QUANTITY"],
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
                                        <div class="custom price col_<?=$arHeader['id']?>">
                                            <span><?=$arHeader["name"]?>:</span>
                                            <div>
                                                <div class="old_price" id="old_price_<?=$arItem["ID"]?>">
													<?if (floatval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
														<?=$full_price_clean[0]?><span> <?=$full_price_clean[1]?></span>
													<?endif;?>
                                                </div>
                                                <div class="current_price" id="current_price_<?=$arItem["ID"]?>">
													<?=$price_clean[0]?><span> <?=$price_clean[1]?></span>
                                                </div>

												<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
                                                    <div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
                                                    <div class="type_price_value"><?=$arItem["NOTES"]?></div>
												<?endif;?>
                                            </div>
                                        </div>
										<?
                                    elseif ($arHeader["id"] == "DISCOUNT"):
										?>
                                        <div class="custom col_<?=$arHeader['id']?>">
                                            <span><?=$arHeader["name"]; ?>:</span>
                                            <div id="discount_value_<?=$arItem["ID"]?>"><?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
                                        </div>
										<?
                                    elseif ($arHeader["id"] == "WEIGHT"):
										?>
                                        <div class="custom col_<?=$arHeader['id']?>">
                                            <span><?=$arHeader["name"]; ?>:</span>
                                            <div><?=$arItem["WEIGHT_FORMATED"]?></div>
                                        </div>
										<?
                                    elseif ($arHeader["id"] == "SUM"):
										?>
                                        <div class="custom price col_<?=$arHeader['id']?>">
                                            <span><?=$arHeader["name"]; ?>:</span>

                                            <div class="current_price" id="sum_<?=$arItem["ID"]?>">

												<?$pf = i_price_currency_division($arItem[$arHeader["id"]]);?>
                                                <?=$pf[0]?>&nbsp;<span class="i_currency"><?=$pf[1]?></span>

                                            </div>
                                        </div>
										<?
									endif;
									endforeach;?>
							</td>
						</tr>
					<?endif;
				endforeach;
				?>
				</tbody>
			</table>
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
						<div class="bx_input_coupon_wrap">
							<span class="bx_input_coupon"><?=GetMessage("STB_COUPON_PROMT")?></span>
							<input type="text" id="coupon" name="COUPON" value="<?=$arResult["COUPON"]?>" onchange="enterCoupon();" size="21" class="<?=$couponClass?>" style="width: 300px">
						</div>
					<?else:?>
						&nbsp;
					<?endif;?>

					<?if( CSite::InDir(SITE_DIR.'personal/basket.php') ):?>
						<div class="i_ba_buttom">
							<a class="i_ba_fpay jq_ba_fpay" href="javascript:void(0)"<?//if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo ' jq_basket="Y"'?>>
								<span><?=GetMessage('FORMD_PAYMENT')?></span>
							</a>
							<?/*<div class="i_modal j_modal ipabs" id="jq_ba_fpay">
								<div class="i_modal_tit" id="i_pos_bfpay">
									<div class="jqm_fpay"><?=GetMessage('FORMD_PAYMENT')?></div>
									<div class="i_modal_close j_modal_close ipabs"></div>
								</div>
								<div class="i_modal_in">
									<div class="jqm_fpay" id="jqm_fpay"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_fpay.php',Array(),Array('MODE'=>'html', 'NAME'=>'Виды оплаты', 'SHOW_BORDER'=>true))?></div>
								</div>
							</div>*/?>
							<a class="i_ba_dmet jq_ba_dmet" href="javascript:void(0)"<?//if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo ' jq_basket="Y"'?>>
								<span><?=GetMessage('DELIVERY_METHODS')?></span>
							</a>
							<?/*<div class="i_modal j_modal ipabs" id="jq_ba_dmet">
								<div class="i_modal_tit" id="i_pos_bdmet">
									<div class="jqm_dmet"><?=GetMessage('DELIVERY_METHODS')?></div>
									<div class="i_modal_close j_modal_close ipabs"></div>
								</div>
								<div class="i_modal_in">
									<div class="jqm_dmet" id="jqm_dmet"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/m_dmet.php',Array(),Array('MODE'=>'html', 'NAME'=>'Способы доставки', 'SHOW_BORDER'=>true))?></div>
								</div>
							</div>*/?>
						</div>
					<?endif?>
				</div>
			</div>
			<?
			$arResult["PRICE_WITHOUT_DISCOUNT"] = i_price_currency_division($arResult["PRICE_WITHOUT_DISCOUNT"]);
			$arResult["allSum_wVAT_FORMATED"] = i_price_currency_division($arResult["allSum_wVAT_FORMATED"]);
			$arResult["allVATSum_FORMATED"] = i_price_currency_division($arResult["allVATSum_FORMATED"]);
			$arResult["allSum_FORMATED"] = i_price_currency_division($arResult["allSum_FORMATED"]);
			?>
			<div class="bx_ordercart_order_pay_right">
				<div class="bx_ordercart_order_sum">
					<?if ($bWeightColumn):?>
						<div class="bx_ordercart_order_sum_col">
							<div class="bx_ordercart_order_sum_col_cont">
								<div class="custom_t1"><?=GetMessage("SALE_TOTAL_WEIGHT")?></div>
								<div class="custom_t2" id="allWeight_FORMATED"><?=$arResult["allWeight_FORMATED"]?></div>
							</div>
						</div>
					<?endif?>
					<?if (floatval($arResult["DISCOUNT_PRICE_ALL"]) > 0):?>
						<div class="bx_ordercart_order_sum_col">
							<div class="bx_ordercart_order_sum_col_cont">
								<div class="custom_t1 padleft">Цена без скидки:</div>
								<div class="custom_t2" style="text-decoration:line-through; color:#111212;" id="PRICE_WITHOUT_DISCOUNT">
									<?=$arResult["PRICE_WITHOUT_DISCOUNT"][0]?><span> <?=$arResult["PRICE_WITHOUT_DISCOUNT"][1]?></span>
								</div>
							</div>
						</div>
					<?endif?>
					<?if ($arParams["PRICE_VAT_SHOW_VALUE"] == "Y"):?>
						<div class="bx_ordercart_order_sum_col">
							<div class="bx_ordercart_order_sum_col_cont">
								<div class="padleft"><?=GetMessage('SALE_VAT_EXCLUDED')?></div>
								<div id="allSum_wVAT_FORMATED" class="ifont115"><?=$arResult["allSum_wVAT_FORMATED"][0]?><span> <?=$arResult["allSum_wVAT_FORMATED"][1]?></span></div>
							</div>
						</div>
						<div class="bx_ordercart_order_sum_col">
							<div class="bx_ordercart_order_sum_col_cont">
								<div class="padleft"><?=GetMessage('SALE_VAT_INCLUDED')?></div>
								<div id="allVATSum_FORMATED" class="ifont115"><?=$arResult["allVATSum_FORMATED"][0]?><span> <?=$arResult["allVATSum_FORMATED"][1]?></span></div>
							</div>
						</div>
					<?endif?>
					<div class="bx_ordercart_order_sum_col">
						<div class="bx_ordercart_order_sum_col_cont">
							<div class="padleft"><?=GetMessage("SALE_TOTAL")?></div>
							<div class="fwb" id="allSum_FORMATED"><?=$arResult["allSum_FORMATED"][0]?><span> <?=$arResult["allSum_FORMATED"][1]?></span></div>
						</div>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div style="clear:both"></div>

			<?if( $arParams['TERMS_OF_USE']=='Y' ):?>
				<div class="ab_bai_terms_of_use iprel" align="center">
					<div class="jq_ba_terms_of_use i_ba_terms_of_use idnone ipabs">
						<div class="i_bs_close jq_bat_close ifont170 ipabs">×</div>
						<?=GetMessage('TERMS_OF_USE')?>
					</div>
					<input class="jq_bai_terms_of_use" type="checkbox" id="terms_of_use" style="margin: 1px 5px 0px 0px;"><label for="terms_of_use"><?=GetMessage('TERMS_OF_USE_1')?></label> <a target="_blank" href="<?=SITE_DIR?>delivery/"><?=GetMessage('TERMS_OF_USE_2')?></a> <?=GetMessage('TERMS_OF_USE_3')?>
				</div>
			<?endif?>

			<div class="bx_ordercart_order_pay_center<?if( CSite::InDir(SITE_DIR.'personal/basket.php') )echo ' italign_c'?> place_order_div iprel aclear">

				<?if ($arParams["USE_PREPAYMENT"] == "Y" && strlen($arResult["PREPAY_BUTTON"]) > 0):?>
					<?=$arResult["PREPAY_BUTTON"]?>
					<span><?=GetMessage("SALE_OR")?></span>
				<?endif;

				$limit_order = $arParams['I_MIN_PUTCHASE_AMOUNT'] && $arResult['allSum']<=$arParams['I_MIN_PUTCHASE_AMOUNT'];?>

				<a href="javascript:void(0)" onclick="<?if( !$limit_order ):?>checkOut()<?endif;?>" class="checkout i_place_order i_but_ac jq_checkout<?if( CSite::InDir(SITE_DIR.'personal/basket/index.php') )echo ' ifright';if( $limit_order )echo ' i_checkout_inactive';?>" jqsum="<?=$arParams['I_MIN_PUTCHASE_AMOUNT']?>"<?if($arParams['I_MIN_PUTCHASE_AMOUNT'])echo ' jq_chec_act="Y"'?>><?=GetMessage("SALE_ORDER")?></a>
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
	<pre><?print_r($arResult["GRID"]["ROWS"])?></pre>
<?endif*/?>