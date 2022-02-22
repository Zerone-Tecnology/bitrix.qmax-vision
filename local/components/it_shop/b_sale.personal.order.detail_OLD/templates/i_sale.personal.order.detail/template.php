<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

$status_color = 'gray';

switch($arResult['STATUS_ID'])
{
	case 'N': $status_color = 'green'; break;
	case 'P': $status_color = 'yellow'; break;
	case 'F': $status_color = 'gray'; break;
	case 'D': $status_color = 'gray'; break;
	case 'PSEUDO_CANCELLED': $status_color = 'red'; break;
	default: $status_color = 'gray'; break;
}

?>

    <div class="bx_my_order_switch detail">
        <a class="bx_mo_link i_but_ou i_but_ou_detail" href="<?=$arResult["URL_TO_LIST"]?>"><?=GetMessage('SPOD_CUR_ORDERS')?></a>
    </div>

    <div class="bx_order_list">

		<?if(strlen($arResult["ERROR_MESSAGE"])):?>

			<?=ShowError($arResult["ERROR_MESSAGE"]);?>

		<?else:?>

            <div class="bx_order_list_table">
                <div class="bx_order_list_table_head">
                    <div class="bx_order_list_table_head_row">
                        <div class="bx_order_list_table_head_title">
                            <h3><?=GetMessage('SPOD_ORDER')?> <?=GetMessage('SPOD_NUM_SIGN')?><?=$arResult["ACCOUNT_NUMBER"]?></h3>
							<?if(strlen($arResult["DATE_INSERT_FORMATED"])):?>
								<?=GetMessage("SPOD_FROM")?> <?=$arResult["DATE_INSERT_FORMATED"]?>
							<?endif?>
                        </div>
                    </div>
                </div>
                <div class="bx_order_list_table_body">
                    <div class="bx_order_list_table_body_row">
                        <div class="bx_order_list_table_body_col">
							<?=GetMessage('SPOD_ORDER_STATUS')?>:
                        </div>
                        <div class="bx_order_list_table_body_col <?=$status_color;?>">
                            <b>
								<?=$arResult["STATUS"]["NAME"]?>
								<?if(strlen($arResult["DATE_STATUS_FORMATED"])):?>
                                    (<?=GetMessage("SPOD_FROM")?> <?=$arResult["DATE_STATUS_FORMATED"]?>)
								<?endif?>
                            </b>
                        </div>
                    </div>
                    <div class="bx_order_list_table_body_row">
                        <div class="bx_order_list_table_body_col">
							<?=GetMessage('SPOD_ORDER_PRICE')?>:
                        </div>
                        <div class="bx_order_list_table_body_col">
                            <b>
								<?=$arResult["PRICE_FORMATED"]?>
								<?if(floatval($arResult["SUM_PAID"])):?>
                                    (<?=GetMessage('SPOD_ALREADY_PAID')?>:&nbsp;<?=$arResult["SUM_PAID_FORMATED"]?>)
								<?endif?>
                            </b>
                        </div>
                    </div>

					<?if($arResult["CANCELED"] == "Y" || $arResult["CAN_CANCEL"] == "Y"):?>
                        <div class="bx_order_list_table_body_row cancel">
                            <div class="bx_order_list_table_body_col"><?=GetMessage('SPOD_ORDER_CANCELED')?>:</div>
                            <div class="bx_order_list_table_body_col cancel">
                                <b>
									<?if($arResult["CANCELED"] == "Y"):?>
										<?=GetMessage('SPOD_YES')?>
										<?if(strlen($arResult["DATE_CANCELED_FORMATED"])):?>
                                            (<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_CANCELED_FORMATED"]?>)
										<?endif?>
									<?elseif($arResult["CAN_CANCEL"] == "Y"):?>
                                        <span class="i_spod_no"><?=GetMessage('SPOD_NO')?></span>&nbsp;&nbsp;&nbsp;<a class="i_but_ou i_but_ou_cancel" href="<?=$arResult["URL_TO_CANCEL"]?>"><span><?=GetMessage("SPOD_ORDER_CANCEL")?></span></a>
									<?endif?>
                                </b>
                            </div>
                        </div>
					<?endif?>
                </div>
            </div>

            <div class="bx_order_list_table_order">
                <div class="bx_order_list_table_order_head">
                    <div class="bx_order_list_table_order_head_title">
                        <h3><?=GetMessage('SPOD_ORDER_BASKET')?></h3>
                    </div>
                </div>
                <div class="bx_order_list_table_order_body">
                    <div class="bx_order_list_table_order_body_row">
                        <div class="bx_order_list_table_order_body_col"><?=GetMessage('SPOD_NAME')?></div>

                        <div class="bx_order_list_table_order_body_col custom price"><?=GetMessage('SPOD_QUANTITY')?></div>

                        <div class="bx_order_list_table_order_body_col custom price"><?=GetMessage('SPOD_PRICE')?></div>

						<?/*if($arResult['HAS_PROPS']):?>
						<td class="custom amount"><?=GetMessage('SPOD_PROPS')?></td>
					<?endif*/?>

						<?if($arResult['HAS_DISCOUNT']):?>
                            <div class="bx_order_list_table_order_body_col custom price"><?=GetMessage('SPOD_DISCOUNT')?></div>
						<?endif?>
						<?/*<td class="custom amount"><?=GetMessage('SPOD_PRICETYPE')?></td>*/?>
                    </div>
                </div>
                <div class="bx_order_list_table_order_foot">

					<?foreach($arResult["BASKET"] as $prod):?>
                        <div class="bx_order_list_table_order_foot_row">
                            <div class="bx_order_list_table_order_foot_col"><div class="bx_order_list_table_order_foot_col_cont">
									<?$hasLink = !empty($prod["DETAIL_PAGE_URL"]);?>
                                    <div class="custom img">
										<?if($hasLink):?>
                                        <a href="<?=$prod["DETAIL_PAGE_URL"]?>" target="_blank">
											<?endif?>

											<?if($arResult['I_PRODUCT_ITEMS'][$prod['PRODUCT_ID']]['PICTURE'])
												$pick = $arResult['I_PRODUCT_ITEMS'][$prod['PRODUCT_ID']]['PICTURE'];
                                            elseif( $arResult['I_PRODUCT_ITEMS'][$prod['PARENT']['ID']]['PICTURE'] )
												$pick = $arResult['I_PRODUCT_ITEMS'][$prod['PARENT']['ID']]['PICTURE'];
											else
												$pick = $this->GetFolder().'/images/no_photo.png';?>

                                            <div class="ok_order_detail_img"><?=CFile::ShowImage($pick, 69, 69, 'alt="'.$prod['NAME'].'"')?></div>

											<?/*							<img src="<?=$prod['PICTURE']['SRC']?>" width="<?=$prod['PICTURE']['WIDTH']?>" height="<?=$prod['PICTURE']['HEIGHT']?>" alt="<?=$prod['NAME']?>" />*/?>

											<?if($hasLink):?>
                                        </a>
                                    </div>
								<?endif?>
                                    <div class="custom name">
										<?if($hasLink):?>
                                        <a href="<?=$prod["DETAIL_PAGE_URL"]?>" target="_blank">
											<?endif?>
											<?=htmlspecialcharsEx($prod["NAME"])?>
											<?if($hasLink):?>
                                        </a>
                                    </div>
								<?endif?></div>
                            </div>

                            <div class="bx_order_list_table_order_foot_col custom quan">
                                <span class="fm"><?=GetMessage('SPOD_QUANTITY')?>:&nbsp;&nbsp;</span><?=$prod["QUANTITY"]?>
								<?if(strlen($prod['MEASURE_TEXT'])):?>
									<?=$prod['MEASURE_TEXT']?>
								<?else:?>
									<?=GetMessage('SPOD_DEFAULT_MEASURE')?>
								<?endif?>
                            </div>
							<?$prod["PRICE_FORMATED"] = i_price_currency_division($prod["PRICE_FORMATED"])?>
                            <div class="bx_order_list_table_order_foot_col custom price"> <span class="fm"><?=GetMessage('SPOD_PRICE')?>:&nbsp;&nbsp;</span><span><?=$prod["PRICE_FORMATED"][0]?></span><span class="i_tg"> <?=$prod["PRICE_FORMATED"][1]?></span></div>

							<?/*if($arResult['HAS_PROPS']):?>
							<?
							$actuallyHasProps = is_array($prod["PROPS"]	) && !empty($prod["PROPS"]);
							?>
							<td class="custom"><?//if($actuallyHasProps):?><?//<span class="fm"><?=GetMessage('SPOD_PROPS')?>:<?//</span><?endif?>

								<table cellspacing="0" class="bx_ol_sku_prop">
									<?if($actuallyHasProps):?>
										<?foreach($prod["PROPS"] as $prop):?>

											<?if(!empty($prop['SKU_VALUE']) && $prop['SKU_TYPE'] == 'image'):?>

												<tr>
													<td colspan="2">
														<nobr><?=$prop["NAME"]?>:</nobr><br />
														<img src="<?=$prop['SKU_VALUE']['PICT']['SRC']?>" width="<?=$prop['SKU_VALUE']['PICT']['WIDTH']?>" height="<?=$prop['SKU_VALUE']['PICT']['HEIGHT']?>" title="<?=$prop['SKU_VALUE']['NAME']?>" alt="<?=$prop['SKU_VALUE']['NAME']?>" />
													</td>
												</tr>

											<?else:?>

												<tr>
													<td><nobr><?=$prop["NAME"]?>:</nobr></td>
													<td style="padding-left: 10px !important"><b><?=$prop["VALUE"]?></b></td>
												</tr>

											<?endif?>

										<?endforeach?>
									<?endif?>

								</table>

							</td>
						<?endif*/?>

							<?if($arResult['HAS_DISCOUNT']):?>
                                <div class="bx_order_list_table_order_foot_col custom price"><?/* <span class="fm"><?=GetMessage('SPOD_DISCOUNT')?>:</span> */?><?=$prod["DISCOUNT_PRICE_PERCENT_FORMATED"]?></div>
							<?endif?>

							<?/*<td class="custom amount"><span class="fm"><?=GetMessage('SPOD_PRICETYPE')?>:</span> <?=htmlspecialcharsEx($prod["NOTES"])?></td>*/?>
                        </div>
					<?endforeach?>

                </div>
            </div>
			<?
			/*$arResult['TAX_VALUE_FORMATED'] = i_price_currency_division($arResult['TAX_VALUE_FORMATED']);
			$arResult['PRICE_DELIVERY_FORMATED'] = i_price_currency_division($arResult['PRICE_DELIVERY_FORMATED']);*/
			$arResult['PRICE_FORMATED'] = i_price_currency_division($arResult['PRICE_FORMATED']);

			?>
            <div class="bx_ordercart_order_sum">
                <div class="bx_ordercart_order_sum_body">
                    <div class="bx_ordercart_order_sum_body_row">
						<?if(floatval($arResult['TAX_VALUE'])):?>
                            <div class="bx_ordercart_order_sum_body_col">
								<?=GetMessage('SPOD_TAX')?>:&nbsp;<span class="i_or_itog"><?=$arResult['TAX_VALUE_FORMATED']?></span>
                            </div>
						<?endif?>
						<?if(strlen($arResult['PRICE_DELIVERY_FORMATED'])):?>
                            <div class="bx_ordercart_order_sum_body_col">
								<?=GetMessage('SPOD_DELIVERY')?>:&nbsp;<span class="i_or_itog"><?=$arResult['PRICE_DELIVERY_FORMATED']?></span>
                            </div>
						<?endif?>
                        <div class="bx_ordercart_order_sum_body_col">
							<?=GetMessage('SPOD_SUMMARY')?>:&nbsp;&nbsp;<span class="i_or_itog sum"><?=$arResult['PRICE_FORMATED'][0]?></span><span> <?=$arResult['PRICE_FORMATED'][1]?></span>
                        </div>
                    </div>
                </div>
				<?/*
				<? ///// WEIGHT ?>
				<?if(floatval($arResult["ORDER_WEIGHT"])):?>
					<tr>
						<td class="custom_t1"><?=GetMessage('SPOD_TOTAL_WEIGHT')?>:</td>
						<td class="custom_t2"><?=$arResult['ORDER_WEIGHT_FORMATED']?></td>
					</tr>
				<?endif?>

				<? ///// PRICE SUM ?>
				<tr>
					<td class="custom_t1"><?=GetMessage('SPOD_PRODUCT_SUM')?>:</td>
					<td class="custom_t2"><?=$arResult['PRODUCT_SUM_FORMATTED']?></td>
				</tr>

				<? ///// DELIVERY PRICE: print even equals 2 zero ?>
				<?if(strlen($arResult["PRICE_DELIVERY_FORMATED"])):?>
					<tr>
						<td class="custom_t1"><?=GetMessage('SPOD_DELIVERY')?>:</td>
						<td class="custom_t2"><?=$arResult["PRICE_DELIVERY_FORMATED"]?></td>
					</tr>
				<?endif?>

				<? ///// TAXES DETAIL ?>
				<?foreach($arResult["TAX_LIST"] as $tax):?>
					<tr>
						<td class="custom_t1"><?=$tax["TAX_NAME"]?>:</td>
						<td class="custom_t2"><?=$tax["VALUE_MONEY_FORMATED"]?></td>
					</tr>
				<?endforeach?>

				<? ///// TAX SUM ?>
				<?if(floatval($arResult["TAX_VALUE"])):?>
					<tr>
						<td class="custom_t1"><?=GetMessage('SPOD_TAX')?>:</td>
						<td class="custom_t2"><?=$arResult["TAX_VALUE_FORMATED"]?></td>
					</tr>
				<?endif?>

				<? ///// DISCOUNT ?>
				<?if(floatval($arResult["DISCOUNT_VALUE"])):?>
					<tr>
						<td class="custom_t1"><?=GetMessage('SPOD_DISCOUNT')?>:</td>
						<td class="custom_t2"><?=$arResult["DISCOUNT_VALUE_FORMATED"]?></td>
					</tr>
				<?endif?>

				<tr>
					<td class="custom_t1 fwb"><?=GetMessage('SPOD_SUMMARY')?>:</td>
					<td class="custom_t2 fwb"><?=$arResult["PRICE_FORMATED"]?></td>
				</tr>
*/?>
            </div>

			<?if($arResult['CAN_REPAY']=='Y' && $arResult['PAY_SYSTEM']['PSA_NEW_WINDOW'] == 'Y'):?>
                <div class="i_or_gen_in_pay">
                    <a class="i_but_ac" href="<?=$arResult['PAY_SYSTEM']['PSA_ACTION_FILE']?>" target="_blank"><?=GetMessage('SPOD_REPEAT_PAY')?></a>
                </div>
			<?endif?>

            <div class="bx_order_list_table">
                <div class="bx_order_list_table_body">
					<?if(intval($arResult["USER_ID"])):?>

                        <div class="bx_order_list_table_body_row">
                            <div class="bx_order_list_table_body_title"><h3><?=GetMessage('SPOD_ACCOUNT_DATA')?></h3></div>
                        </div>
						<?if(strlen($arResult["USER_NAME"])):?>
                            <div class="bx_order_list_table_body_row">
                                <div class="bx_order_list_table_body_col"><?=GetMessage('SPOD_ACCOUNT')?>:</div>
                                <div class="bx_order_list_table_body_col">
                                    <b>
										<?=$arResult["USER_NAME"]?>
                                    </b>
                                </div>
                            </div>
						<?endif?>
                        <div class="bx_order_list_table_body_row">
                            <div class="bx_order_list_table_body_col"><?=GetMessage('SPOD_LOGIN')?>:</div>
                            <div class="bx_order_list_table_body_col">
                                <b>
									<?=$arResult["USER"]["LOGIN"]?>
                                </b>
                            </div>
                        </div>
                        <div class="bx_order_list_table_body_row">
                            <div class="bx_order_list_table_body_col"><?=GetMessage('SPOD_EMAIL')?>:</div>
                            <div class="bx_order_list_table_body_col">
                                <b>
                                    <a href="mailto:<?=$arResult["USER"]["EMAIL"]?>"><?=$arResult["USER"]["EMAIL"]?></a>
                                </b>
                            </div>
                        </div>
                        <div class="i_pro_det_dashed"></div>
					<?endif?>

                    <div class="bx_order_list_table_body_row">
                        <div class="bx_order_list_table_body_title"><h3><?=GetMessage('SPOD_ORDER_PROPERTIES')?></h3></div>
                    </div>
                    <div class="bx_order_list_table_body_row">
                        <div class="bx_order_list_table_body_col"><?=GetMessage('SPOD_ORDER_PERS_TYPE')?>:</div>
                        <div class="bx_order_list_table_body_col">
                            <b>
								<?=$arResult["PERSON_TYPE"]["NAME"]?>
                            </b>
                        </div>
                    </div>
                    <div class="i_pro_det_dashed"></div>
					<?/*
				<tr>
					<td><?=GetMessage('SPOD_ORDER_COMPLETE_SET')?>:</td>
					<td></td>
				</tr>
				*/?>

					<?foreach($arResult["ORDER_PROPS"] as $prop):?>
						<?if($prop["SHOW_GROUP_NAME"] == "Y"):?>
                            <div class="bx_order_list_table_body_row">
                                <div class="bx_order_list_table_body_title"><h3><?=$prop["GROUP_NAME"]?></h3></div>
                            </div>
						<?endif?>
                        <div class="bx_order_list_table_body_row">

                            <div class="bx_order_list_table_body_col"><?=$prop['NAME']?>:</div>
                            <div class="bx_order_list_table_body_col">
                                <b>
									<?if($prop["TYPE"] == "CHECKBOX"):?>
										<?=GetMessage('SPOD_'.($prop["VALUE"] == "Y" ? 'YES' : 'NO'))?>
									<?else:?>
										<?=$prop["VALUE"]?>
									<?endif?>
                                </b>
                            </div>
                        </div>
					<?endforeach?>

					<?if(!empty($arResult["USER_DESCRIPTION"])):?>
                        <div class="bx_order_list_table_body_row">
                            <div class="bx_order_list_table_body_col"><?=GetMessage('SPOD_ORDER_USER_COMMENT')?>:</div>
                            <div class="bx_order_list_table_body_col"><b><?=$arResult["USER_DESCRIPTION"]?></b></div>
                        </div>
					<?endif?>
                    <div class="i_pro_det_dashed"></div>
                    <div class="bx_order_list_table_body_row">
                        <div class="bx_order_list_table_body_title"><h3><?=GetMessage("SPOD_ORDER_PAYMENT")?></h3></div>
                    </div>
                    <div class="bx_order_list_table_body_row">
                        <div class="bx_order_list_table_body_col"><?=GetMessage('SPOD_PAY_SYSTEM')?>:</div>
                        <div class="bx_order_list_table_body_col">
                            <b>
								<?if(intval($arResult["PAY_SYSTEM_ID"])):?>
									<?=$arResult["PAY_SYSTEM"]["NAME"]?>
								<?else:?>
									<?=GetMessage("SPOD_NONE")?>
								<?endif?>
                            </b>
                        </div>
                    </div>
                    <div class="bx_order_list_table_body_row pay_system">
                        <div class="bx_order_list_table_body_col pay_text"><?=GetMessage('SPOD_ORDER_PAYED')?>:
                            &nbsp;&nbsp;&nbsp;<b>
								<?if($arResult["PAYED"] == "Y"):?>
                                    <span class="green"><?=GetMessage('SPOD_YES')?></span>
									<?if(strlen($arResult["DATE_PAYED_FORMATED"])):?>
                                        (<?=GetMessage('SPOD_FROM')?> <?=$arResult["DATE_PAYED_FORMATED"]?>)
									<?endif?>
								<?else:?>
                                    <span class="red"><?=GetMessage('SPOD_NO')?></span>
								<?endif?>
                            </b>
                        </div>
                        <div class="bx_order_list_table_body_col <?if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y") echo ' pay_button'?>">
							<?if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] == "Y"):?>
                                <a class="i_but_ou i_or_gen" href="<?=$arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]?>" target="_blank"><?=GetMessage("SPOD_REPEAT_PAY")?></a>
							<?endif?>
                        </div>
                    </div>

                    <div class="bx_order_list_table_body_row">
                        <div class="bx_order_list_table_body_col"><?=GetMessage("SPOD_ORDER_DELIVERY")?>:</div>
                        <div class="bx_order_list_table_body_col">
							<?if(strpos($arResult["DELIVERY_ID"], ":") !== false || intval($arResult["DELIVERY_ID"])):?>
                                <b><?=$arResult["DELIVERY"]["NAME"]?></b>

								<?if(intval($arResult['STORE_ID']) && !empty($arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']])):?>

									<?$store = $arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']];?>
                                    <div class="bx_ol_store">
                                        <div class="bx_old_s_row_title">
											<?=GetMessage('SPOD_TAKE_FROM_STORE')?>: <b><?=$store['TITLE']?></b>

											<?if(!empty($store['DESCRIPTION'])):?>
                                                <div class="bx_ild_s_desc">
													<?=$store['DESCRIPTION']?>
                                                </div>
											<?endif?>

                                        </div>

										<?if(!empty($store['ADDRESS'])):?>
                                            <div class="bx_old_s_row">
                                                <b><?=GetMessage('SPOD_STORE_ADDRESS')?></b>: <?=$store['ADDRESS']?>
                                            </div>
										<?endif?>

										<?if(!empty($store['SCHEDULE'])):?>
                                            <div class="bx_old_s_row">
                                                <b><?=GetMessage('SPOD_STORE_WORKTIME')?></b>: <?=$store['SCHEDULE']?>
                                            </div>
										<?endif?>

										<?if(!empty($store['PHONE'])):?>
                                            <div class="bx_old_s_row">
                                                <b><?=GetMessage('SPOD_STORE_PHONE')?></b>: <?=$store['PHONE']?>
                                            </div>
										<?endif?>

										<?if(!empty($store['EMAIL'])):?>
                                            <div class="bx_old_s_row">
                                                <b><?=GetMessage('SPOD_STORE_EMAIL')?></b>: <a href="mailto:<?=$store['EMAIL']?>"><?=$store['EMAIL']?></a>
                                            </div>
										<?endif?>

										<?if(($store['GPS_N'] = floatval($store['GPS_N'])) && ($store['GPS_S'] = floatval($store['GPS_S']))):?>

                                            <div id="bx_old_s_map">

                                                <div class="bx_map_buttons">
                                                    <a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" id="map-show">
														<?=GetMessage('SPOD_SHOW_MAP')?>
                                                    </a>

                                                    <a href="javascript:void(0)" class="bx_big bx_bt_button_type_2 bx_cart" id="map-hide">
														<?=GetMessage('SPOD_HIDE_MAP')?>
                                                    </a>
                                                </div>

												<?ob_start();?>
                                                <div><?$mg = $arResult["DELIVERY"]["STORE_LIST"][$arResult['STORE_ID']]['IMAGE'];?>
													<?if(!empty($mg['SRC'])):?><img src="<?=$mg['SRC']?>" width="<?=$mg['WIDTH']?>" height="<?=$mg['HEIGHT']?>"><br /><br /><?endif?>
													<?=$store['TITLE']?></div>
												<?$ballon = ob_get_contents();?>
												<?ob_end_clean();?>

												<?
												$mapId = '__store_map';

												$mapParams = array(
													'yandex_lat' => $store['GPS_N'],
													'yandex_lon' => $store['GPS_S'],
													'yandex_scale' => 16,
													'PLACEMARKS' => array(
														array(
															'LON' => $store['GPS_S'],
															'LAT' => $store['GPS_N'],
															'TEXT' => $ballon
														)
													));
												?>

                                                <div id="map-container">

													<?$APPLICATION->IncludeComponent("bitrix:map.yandex.view", ".default", array(
														"INIT_MAP_TYPE" => "MAP",
														"MAP_DATA" => serialize($mapParams),
														"MAP_WIDTH" => "100%",
														"MAP_HEIGHT" => "200",
														"CONTROLS" => array(
															0 => "SMALLZOOM",
														),
														"OPTIONS" => array(
															0 => "ENABLE_SCROLL_ZOOM",
															1 => "ENABLE_DBLCLICK_ZOOM",
															2 => "ENABLE_DRAGGING",
														),
														"MAP_ID" => $mapId
													),
														false
													);?>

                                                </div>

												<?CJSCore::Init();?>
                                                <script>
                                                    new CStoreMap({mapId:"<?=$mapId?>", area: '.bx_old_s_map'});
                                                </script>

                                            </div>

										<?endif?>

                                    </div>

								<?endif?>

							<?else:?>
								<?=GetMessage("SPOD_NONE")?>
							<?endif?>
                        </div>
                    </div>

					<?if($arResult["TRACKING_NUMBER"]):?>

                        <div class="bx_order_list_table_body_row">
                            <div class="bx_order_list_table_body_col"><?=GetMessage('SPOD_ORDER_TRACKING_NUMBER')?>:</div>
                            <div class="bx_order_list_table_body_col">
                                <b>
									<?=$arResult["TRACKING_NUMBER"]?>
                                </b>
                            </div>
                        </div>

					<?endif?>

					<?if($arResult["CAN_REPAY"]=="Y" && $arResult["PAY_SYSTEM"]["PSA_NEW_WINDOW"] != "Y"):?>
                        <div class="bx_order_list_table_body_row">
                            <div class="bx_order_list_table_body_col">
								<?
								$ORDER_ID = $ID;
								include($arResult["PAY_SYSTEM"]["PSA_ACTION_FILE"]);
								?>
                            </div>
                        </div>
					<?endif?>

                </div>
            </div>

            <div class="bx_control_table" style="width: 100%;">
                <div class="bx_control_table_row">
                    <div class="bx_control_table_col">
                        <a class="i_but_ou i_but_ou_detail" href="<?=$arResult["URL_TO_LIST"]?>" class="bx_big bx_bt_button_type_2 bx_cart">
							<?=GetMessage('SPOD_GO_BACK')?></a></div>
                </div>
            </div>

		<?endif?>

    </div>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arResult)?></pre>
<?endif*/?>