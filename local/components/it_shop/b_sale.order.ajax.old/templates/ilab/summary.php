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
		<div class="i_info ifleft"><?=GetMessage('COMMENT')?></div>
		<div class="bx_block w100 ifleft"><textarea name="ORDER_DESCRIPTION" id="ORDER_DESCRIPTION" style="max-width:774px;min-width: 774px;min-height:120px"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea></div>
		<div class="iclear"></div>
		<input type="hidden" name="" value="">
		<div style="clear: both;"></div>
	</div>
	<h3><?=GetMessage("SALE_PRODUCTS_SUMMARY");?></h3>
	<div class="bx_ordercart_order_table_container iprel">
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
			<div class="item" id="col_<?=$arColumn['id']?>">
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
						<?endforeach;?>
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
											else:
												$url = $templateFolder."/images/no_photo.png";
											endif;

											if (strlen($arData["data"]["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arData["data"]["DETAIL_PAGE_URL"] ?>"><?endif;?>
												<div class="bx_ordercart_photo" style="background-image:url('<?=$url?>')"></div>
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
							<?
							elseif ($arColumn["id"] == "PRICE_FORMATED"):
								?>
								<div class="price right">
									<div class="current_price">
										<?=$arItem["PRICE_FORMATED"]?>
									</div>
									<div class="old_price right">
										<s>
											<?if (doubleval($arItem["DISCOUNT_PRICE"]) > 0):
												echo SaleFormatCurrency($arItem["PRICE"] + $arItem["DISCOUNT_PRICE"], $arItem["CURRENCY"]);
												$bUseDiscount = true;
											endif?>
										</s>
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
								<div class="custom right">
									<span class="idnone"><?=getColumnName($arColumn)?>:</span>
									<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
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
							elseif (in_array($arColumn["id"], array("QUANTITY", "WEIGHT_FORMATED", "DISCOUNT_PRICE_PERCENT_FORMATED", "SUM"))):
								?>
								<div class="custom right <?=$arColumn["id"]?>">
									<span class="idnone"><?=getColumnName($arColumn)?>:</span>
									<span class="custom_text"><?=$arItem[$arColumn["id"]]?></span>
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
									<?
								else: // not array, but simple value
									?>
									<div class="custom" style="<?=$columnStyle?>">
										<span class="idnone"><?=getColumnName($arColumn)?>:</span>
										<?
										echo $arItem[$arColumn["id"]];
										?>
									</div>
									<?
								endif;
							endif;

							endforeach;?>
						</div>
						<?/*if($co==$i):?>
				<tr>
							<td colspan="6"><br><a href="/personal/basket.php" class="i_hback"><?=GetMessage('BACK_BASKET')?></a></td>
				</tr>
					<?endif*/?>
						<?$i++;endforeach?>
				</div>
			</div>

			<div class="bx_ordercart_order_pay ipabs">
				<div class="bx_ordercart_order_pay_right">
					<table class="bx_ordercart_order_sum">
						<tbody>
						<tr>
							<td>
								<div class="bx_ordercart_order_sum_row">
									<div class="custom_t1" class="itog"><?=GetMessage("SOA_TEMPL_SUM_WEIGHT_SUM")?></div>
									<div class="custom_t2" valign="top"><?=$arResult["ORDER_WEIGHT_FORMATED"]?></div>
								</div>
								<div class="bx_ordercart_order_sum_row">
									<div class="custom_t1 i_w50" class="itog"><?=GetMessage("SOA_TEMPL_SUM_SUMMARY")?></div>
									<div class="custom_t2 i_w50 price" valign="top"><?=$arResult["ORDER_PRICE_FORMATED"]?></div>
								</div>
								<?
								if (doubleval($arResult["DISCOUNT_PRICE"]) > 0)
								{
									?>
									<div class="bx_ordercart_order_sum_row">
										<div class="custom_t1" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DISCOUNT")?><?if (strLen($arResult["DISCOUNT_PERCENT_FORMATED"])>0):?> (<?echo $arResult["DISCOUNT_PERCENT_FORMATED"];?>)<?endif;?>:</div>
										<div class="custom_t2 price" valign="top"><?echo $arResult["DISCOUNT_PRICE_FORMATED"]?></div>
									</div>
									<?
								}
								if(!empty($arResult["TAX_LIST"]))
								{
									foreach($arResult["TAX_LIST"] as $val)
									{
										?>
										<div class="bx_ordercart_order_sum_row">
											<div class="custom_t1" class="itog"><?=$val["NAME"]?><br><small><?=$val["VALUE_FORMATED"]?></small>:</div>
											<div class="custom_t2 price" valign="top"><?=$val["VALUE_MONEY_FORMATED"]?></div>
										</div>
										<?
									}
								}
								if (doubleval($arResult["DELIVERY_PRICE"]) > 0)
								{
									?>
									<div class="bx_ordercart_order_sum_row">
										<div class="custom_t1" class="itog"><?=GetMessage("SOA_TEMPL_SUM_DELIVERY")?></div>
										<div class="custom_t2 price" valign="top"><?=$arResult["DELIVERY_PRICE_FORMATED"]?></div>
									</div>
									<?
								}
								if (strlen($arResult["PAYED_FROM_ACCOUNT_FORMATED"]) > 0)
								{
									?>
									<div class="bx_ordercart_order_sum_row">
										<div class="custom_t1" class="itog"><?=GetMessage("SOA_TEMPL_SUM_PAYED")?></div>
										<div class="custom_t2 price" valign="top"><?=$arResult["PAYED_FROM_ACCOUNT_FORMATED"]?></div>
									</div>
									<?
								}?>
							</td>
						</tr>
						</tbody>
					</table>
					<table>
						<?if ($bUseDiscount):?>
							<tr>
								<td class="custom_t1 fwb i_w50" class="itog"><?=GetMessage("SOA_TEMPL_SUM_IT")?></td>
								<td class="custom_t2 price fwb i_w50"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></td>
							</tr>
							<tr>
								<td class="custom_t1"></td>
								<td class="custom_t2" style="text-decoration:line-through; color:#828282;"><?=$arResult["PRICE_WITHOUT_DISCOUNT"]?></td>
							</tr>
						<?else:?>
							<tr><td colspan="2"></td></tr>
							<tr>
								<td class="custom_t1 fwb" align="right"><?=GetMessage("SOA_TEMPL_SUM_IT")?></td>
								<td class="custom_t2 fwb itog price" align="left"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></td>
							</tr>
						<?endif?>
						<?/*
						<tr>
							<td colspan="2" align="center">
								<a href="javascript:void()" onclick="submitForm('Y'); return false;" class="checkout i_but_ac"><?=GetMessage("SOA_TEMPL_BUTTON")?></a>
							</td>
						</tr>
*/?>
					</table>
					<div style="clear:both"></div>

				</div>
				<div style="clear:both"></div>
			</div>
		</div>

	</div>

	<div class="place_order_div">
		<a href="javascript:void()" onclick="submitForm('Y'); return false;" class="checkout i_but_ac i_place_order ifont130"><?=GetMessage('SOA_TEMPL_BUTTON')?></a>
	</div>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>