<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDefaultColumns = $arResult["GRID"]["DEFAULT_COLUMNS"];
$colspan = ($bDefaultColumns) ? count($arResult["GRID"]["HEADERS"]) : count($arResult["GRID"]["HEADERS"]) - 1;
$bPropsColumn = false;
$bUseDiscount = false;
$bPriceType = false;
$bShowNameWithPicture = ($bDefaultColumns) ? true : false; // flat to show name and picture column in one column
?>
	<div class="bx_ordercart">
		<div class="bx_section i_or_section i_or_addinfo">
			<h3><?=GetMessage("SOA_TEMPL_SUM_COMMENTS")?></h3>
			<div class="bx_block_wrap">
				<div class="i_info"><?=GetMessage('COMMENT')?></div>
				<div class="i_add_inp bx_block"><textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION" style="min-height: 100px; min-width: 100%; max-width: 100%;"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea></div>
			</div>
			<input type="hidden" name="" value="">
		</div>
		<h3><?=GetMessage("SALE_PRODUCTS_SUMMARY");?></h3>
		<div class="bx_summary_table iprel <?if (doubleval($arResult["DELIVERY_PRICE"]) > 0) echo ' with_del'?> <?if (doubleval($arResult["DISCOUNT_PRICE"]) > 0) echo ' with_disc'?>">
	<div class="bx_ordercart_order_table">
	<div class="bx_ordercart_order_table_head">
		<div class="bx_ordercart_order_table_head_row">
			<?
			$bPreviewPicture = false;
			$bDetailPicture = false;
			$imgCount = 0;

			// prelimenary column handling
			foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
			{
				if ($arColumn["id"] == "PROPS")
					$bPropsColumn = true;

				if ($arColumn["id"] == "NOTES")
					$bPriceType = true;

				if ($arColumn["id"] == "PREVIEW_PICTURE")
					$bPreviewPicture = true;

				if ($arColumn["id"] == "DETAIL_PICTURE")
					$bDetailPicture = true;
			}

			if ($bPreviewPicture || $bDetailPicture)
				$bShowNameWithPicture = true;


			foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

			if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
				continue;

			if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
				continue;

			if ($arColumn["id"] == "NAME" && $bShowNameWithPicture):
			?>
			<div class="itemmain">
			<div class="custom item" id="col_<?=$arColumn['id']?>">
				<?
				echo GetMessage("SALE_PRODUCTS");
				elseif ($arColumn["id"] == "NAME" && !$bShowNameWithPicture):
				?>
				<div class="item" id="col_<?=$arColumn['id']?>">
					<?
					echo $arColumn["name"];
					elseif ($arColumn["id"] == "PRICE"):
					?>
					<div class="price" id="col_<?=$arColumn['id']?>">
						<?
						echo $arColumn["name"];
						else:
						?>
						<div class="custom" id="col_<?=$arColumn['id']?>">
							<?
							echo $arColumn["name"];
							endif;
							?>
						</div>
						<?if ($arColumn["id"] == "NAME" && $bShowNameWithPicture):?>
						</div>
                        <div class="itemsecond">
						<?endif?>
						<?endforeach;?>
						</div>
					</div>
				</div>

				<div class="bx_ordercart_order_table_body">
					<?$co = count($arResult["GRID"]["ROWS"]);$i=1;
					foreach ($arResult["GRID"]["ROWS"] as $k => $arData):?>
						<div class="bx_ordercart_order_table_body_row">
							<div class="itemmain">
								<?
								if ($bShowNameWithPicture):
									?>
									<div class="itemphoto">
										<div class="bx_ordercart_photo_container">
											<?
											if (strlen($arData["data"]["PREVIEW_PICTURE_SRC"]) > 0):
												$url = $arData["data"]["PREVIEW_PICTURE_SRC"];
											elseif (strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0):
												$url = $arData["data"]["DETAIL_PICTURE_SRC"];
											elseif (strlen($arData["data"]["PREVIEW_PICTURE"]) > 0):
												$url = CFile::GetPath($arData["data"]["PREVIEW_PICTURE"]);
											else:
												$url = SITE_TEMPLATE_PATH."/ilab/img/nophoto.png";
											endif;

											if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
												<img class="bx_ordercart_photo" src="<?=$url?>">
												<?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
										</div>
										<?
										if (!empty($arData["data"]["BRAND"])):
											?>
											<div class="bx_ordercart_brand">
												<img alt="" src="<?=$arData["data"]["BRAND"]?>" />
											</div>
											<?
										endif;
										?>
									</div>
									<?
								endif;

								// prelimenary check for images to count column width
								foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn)
								{
									$arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];
									if (is_array($arItem[$arColumn["id"]]))
									{
										foreach ($arItem[$arColumn["id"]] as $arValues)
										{
											if ($arValues["type"] == "image")
												$imgCount++;
										}
									}
								}

								foreach ($arResult["GRID"]["HEADERS"] as $id => $arColumn):

								$class = ($arColumn["id"] == "PRICE_FORMATED") ? "price" : "";

								if (in_array($arColumn["id"], array("PROPS", "TYPE", "NOTES"))) // some values are not shown in columns in this template
									continue;

								if ($arColumn["id"] == "PREVIEW_PICTURE" && $bShowNameWithPicture)
									continue;

								$arItem = (isset($arData["columns"][$arColumn["id"]])) ? $arData["columns"] : $arData["data"];

								if ($arColumn["id"] == "NAME"):
								$width = 70 - ($imgCount * 20);
								?>
								<div class="item"<?/*style="width:<?=$width?>%"*/?>>

									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<?=$arItem["~NAME"]?>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>

									<?/*

								<div class="bx_ordercart_itemart">
									<?
									if ($bPropsColumn):
										foreach ($arItem["PROPS"] as $val):
											echo $val["NAME"].":&nbsp;<span>".$val["VALUE"]."<span><br/>";
										endforeach;
									endif;
									?>
								</div>
								<?
								if (is_array($arItem["SKU_DATA"])):
									foreach ($arItem["SKU_DATA"] as $propId => $arProp):

										// is image property
										$isImgProperty = false;
										foreach ($arProp["VALUES"] as $id => $arVal)
										{
											if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
											{
												$isImgProperty = true;
												break;
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
														<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%;margin-left:0%;">
														<?
														foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

															$selected = "";
															foreach ($arItem["PROPS"] as $arItemProp):
																if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																{
																	if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																		$selected = "class=\"bx_active\"";
																}
															endforeach;
														?>
															<li style="width:10%;" <?=$selected?>>
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
														<ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%; margin-left:0%;">
															<?
															foreach ($arProp["VALUES"] as $valueId => $arSkuValue):

																$selected = "";
																foreach ($arItem["PROPS"] as $arItemProp):
																	if ($arItemProp["CODE"] == $arItem["SKU_DATA"][$propId]["CODE"])
																	{
																		if ($arItemProp["VALUE"] == $arSkuValue["NAME"])
																			$selected = "class=\"bx_active\"";
																	}
																endforeach;
															?>
																<li style="width:10%;" <?=$selected?>>
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
										<div class="i_sku">
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
								</div>
							</div>
							<div class="itemsecond">
							<?
							elseif ($arColumn["id"] == "PRICE_FORMATED"):
								?>
								<div class="custom price">
									<span class="idnone">Цена:</span>
									<div class="custom_cont price_cont">
                                        <div class="old_price">
                                            <s>
												<?if (doubleval($arItem["DISCOUNT_PRICE"]) > 0):
													echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
													$bUseDiscount = true;
												endif?>
                                            </s>
                                        </div>
										<div class="current_price">
											<?$arItem["PRICE_FORMATED"] = i_price_currency_division($arItem["PRICE_FORMATED"]);
											echo $arItem["PRICE_FORMATED"][0];
											?><span> <?=$arItem["PRICE_FORMATED"][1]?></span>
										</div>
									</div>
									<?if ($bPriceType && strlen($arItem["NOTES"]) > 0):?>
										<div style="text-align: left">
											<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
											<div class="type_price_value"><?=$arItem["NOTES"]?></div>
										</div>
									<?endif;?>
								</div>
								<?
							elseif ($arColumn["id"] == "DISCOUNT"):
								?>
								<div class="custom">
									<span class="idnone"><?=getColumnName($arColumn)?>:</span>
									<div class="custom_cont">
										<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
									</div>
								</div>
								<?
							elseif ($arColumn["id"] == "DETAIL_PICTURE" && $bPreviewPicture):
								?>
								<div class="itemphoto">
									<div class="bx_ordercart_photo_container">
										<?
										$url = "";
										if ($arColumn["id"] == "DETAIL_PICTURE" && strlen($arData["data"]["DETAIL_PICTURE_SRC"]) > 0)
											$url = $arData["data"]["DETAIL_PICTURE_SRC"];

										if ($url == "")
											$url = $templateFolder."/images/no_photo.png";

										if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
											<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
											<?if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
									</div>
								</div>
								<?
							elseif (in_array($arColumn["id"], array("QUANTITY", "WEIGHT_FORMATED", "DISCOUNT_PRICE_PERCENT_FORMATED"))):
								?>
								<div class="custom">
									<span class="idnone"><?=getColumnName($arColumn)?>:</span>
									<div class="custom_cont">
										<?=$arItem[$arColumn["id"]]?>
									</div>
								</div>
								<?
							elseif ($arColumn["id"] == "SUM"):
								?>
								<div class="custom price">
									<span class="idnone"><?=getColumnName($arColumn)?>:</span>
									<div class="custom_cont price_cont">
										<?$items_sum = i_price_currency_division($arItem[$arColumn["id"]]);
										echo $items_sum[0]?><span> <?=$items_sum[1]?></span>
									</div>
								</div>
								<?
							else: // some property value

								if (is_array($arItem[$arColumn["id"]])):

									foreach ($arItem[$arColumn["id"]] as $arValues)
										if ($arValues["type"] == "image")
											$columnStyle = "width:20%";
									?>
									<div class="custom" style="<?=$columnStyle?>">
										<span class="idnone"><?=getColumnName($arColumn)?>:</span>
										<div class="custom_cont">
											<?
											foreach ($arItem[$arColumn["id"]] as $arValues):
												if ($arValues["type"] == "image"):
													?>
													<div class="bx_ordercart_photo_container">
														<div class="bx_ordercart_photo" style="background-image:url('<?=$arValues["value"]?>')"></div>
													</div>
													<?
												else: // not image
													echo $arValues["value"]."<br/>";
												endif;
											endforeach;
											?>
										</div>
									</div>
									<?
								else: // not array, but simple value
									?>
									<div class="custom" style="<?=$columnStyle?>">
										<span class="idnone"><?=getColumnName($arColumn)?>:</span>
										<div class="custom_cont">
											<?
											echo $arItem[$arColumn["id"]];
											?>
										</div>
									</div>
									<?
								endif;
							endif;

							endforeach;?>
						</div>
						</div>
						<?/*if($co==$i):?>
				<tr>
							<td colspan="6"><br><a href="/personal/basket.php" class="i_hback"><?=GetMessage('BACK_BASKET')?></a></td>
				</tr>
					<?endif*/?>
						<?$i++;endforeach?>
				</div>
			</div>
			<?
			$weight_div = i_price_currency_division($arResult["ORDER_WEIGHT_FORMATED"]);
			$total_pr = i_price_currency_division($arResult["ORDER_TOTAL_PRICE_FORMATED"]);
			$order_pr = i_price_currency_division($arResult["ORDER_PRICE_FORMATED"]);
			$discount_pr = i_price_currency_division($arResult["DISCOUNT_PRICE_FORMATED"]);
			$sum_without_disc_pr = i_price_currency_division($arResult["PRICE_WITHOUT_DISCOUNT"]);
			$del_pr = i_price_currency_division($arResult["DELIVERY_PRICE_FORMATED"]);
			$p_f_ac_pr = i_price_currency_division($arResult["PAYED_FROM_ACCOUNT_FORMATED"]);
			?>
			<div class="bx_ordercart_order_pay ipabs">
				<div class="bx_ordercart_order_pay_wrap">
					<div class="bx_ordercart_order_pay_table">
						<div class="bx_ordercart_order_pay_table_body">
						<div class="bx_ordercart_order_pay_table_row">
							<div class="bx_ordercart_order_pay_table_col custom_t1 itog"><?=GetMessage("SOA_TEMPL_SUM_WEIGHT_SUM")?></div>
							<div class="bx_ordercart_order_pay_table_col custom_t2"><?=$weight_div[0]?><span> <?=$weight_div[1]?></span></div>
						</div>
						<div class="bx_ordercart_order_pay_table_row">
							<div class="bx_ordercart_order_pay_table_col custom_t1 itog"><?=GetMessage("SOA_TEMPL_SUM_SUMMARY")?></div>
							<div class="bx_ordercart_order_pay_table_col custom_t2 price"><?=$order_pr[0]?><span> <?=$order_pr[1]?></span></div>
						</div>
						<?
						if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
						{
							?>
							<div class="bx_ordercart_order_pay_table_row">
								<div class="bx_ordercart_order_pay_table_col custom_t1 itog"><?=GetMessage("SOA_TEMPL_SUM_DISCOUNT")?><?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?> (<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)<?endif;?>:</div>
								<div class="bx_ordercart_order_pay_table_col custom_t2 price"><?=$discount_pr[0]?><span> <?=$discount_pr[1]?></span></div>
							</div>
							<?
						}
						if(!empty($arResult["TAX_LIST"]))
						{
							foreach($arResult["TAX_LIST"] as $val)
							{
								$tax_val_pr = i_price_currency_division($val["VALUE_MONEY_FORMATED"]);
								?>
								<div class="bx_ordercart_order_pay_table_row">
									<div class="bx_ordercart_order_pay_table_col custom_t1 itog"><?=$val["NAME"]?><br><small><?=$val["VALUE_FORMATED"]?></small>:</div>
									<div class="bx_ordercart_order_pay_table_col custom_t2 price"><?=$tax_val_pr[0]?><span> <?=$tax_val_pr[1]?></span></div>
								</div>
								<?
							}
						}
						if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
						{
							?>
							<div class="bx_ordercart_order_pay_table_row">
								<div class="bx_ordercart_order_pay_table_col custom_t1 itog"><?=GetMessage("SOA_TEMPL_SUM_DELIVERY")?></div>
								<div class="bx_ordercart_order_pay_table_col custom_t2 price"><?=$del_pr[0]?><span> <?=$del_pr[1]?></span></div>
							</div>
							<?
						}
						if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0)
						{
							?>
							<div class="bx_ordercart_order_pay_table_row">
								<div class="bx_ordercart_order_pay_table_col custom_t1 itog"><?=GetMessage("SOA_TEMPL_SUM_PAYED")?></div>
								<div class="bx_ordercart_order_pay_table_col custom_t2 price"><?=$p_f_ac_pr[0]?><span> <?=$p_f_ac_pr[1]?></span></div>
							</div>
							<?
						}?>
						</div>
					</div>
					<div class="bx_ordercart_order_pay_total_table">
						<?if ($bUseDiscount):?>
							<div class="bx_ordercart_order_pay_total_row">
								<div class="bx_ordercart_order_pay_total_col custom_t1" class="itog"><?=GetMessage("SOA_TEMPL_SUM_IT")?></div>
								<div class="bx_ordercart_order_pay_total_col custom_t2 price"><?=$total_pr[0]//$arResult["ORDER_TOTAL_PRICE_FORMATED"]?><span> <?=$total_pr[1]?></span></div>
							</div>
							<?/*<div class="bx_ordercart_order_pay_total_row">
								<div class="bx_ordercart_order_pay_total_col custom_t1"></div>
								<div class="bx_ordercart_order_pay_total_col custom_t2" style="text-decoration:line-through; color:#828282;"><?=$sum_without_disc_pr[0]?><span> <?=$sum_without_disc_pr[1]?></span></div>
							</div>*/?>
						<?else:?>
							<div class="bx_ordercart_order_pay_total_row">
								<div class="bx_ordercart_order_pay_total_col custom_t1 fwb"><?=GetMessage("SOA_TEMPL_SUM_IT")?></div>
								<div class="bx_ordercart_order_pay_total_col custom_t2 fwb itog price"><?=$total_pr[0]//$arResult["ORDER_TOTAL_PRICE_FORMATED"]?><span> <?=$total_pr[1]?></span></div>
							</div>
						<?endif?>
						<?/*
						<tr>
							<td colspan="2" align="center">
								<a href="javascript:void()" onclick="submitForm('Y'); return false;" class="checkout i_but_ac"><?=GetMessage("SOA_TEMPL_BUTTON")?></a>
							</td>
						</tr>
*/?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="place_order_div">
		<?/* if ($arParams['I_PP_CHECK']=='Y'):?>
			<div>
				<input type="checkbox" id="i_pp_check" name="i_pp_check">
				<label for="i_pp_check"><?=$arParams['~I_PP_CHECK_TEXT']?> <span class="bx_sof_req">*</span></label>
			</div>
		<?endif;*/?>
		<a href="javascript:void()" onclick="<?if($arParams['I_PP_CHECK']=='N') echo "submitForm('Y'); return false;"?>" class="checkout i_but_ac i_place_order ifont130"><?=GetMessage('SOA_TEMPL_BUTTON')?></a>
	</div>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>