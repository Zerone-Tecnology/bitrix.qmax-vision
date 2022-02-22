<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$bDelayColumn  = false;
$bDeleteColumn = false;
$bWeightColumn = false;
$bPropsColumn  = false;
?>
<div id="basket_items_delayed" class="bx_ordercart_order_table_container" style="display:none">
	<div id="delayed_items">
		<div class="delayed_items_head">
			<div class="delayed_items_head_row">
				<?
				foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

					if ( in_array($arHeader["id"], array("TYPE", "PRICE", "SUM", "DISCOUNT")) ) // some header columns are shown differently
					{
						continue;
					}
					elseif ($arHeader["id"] == "PROPS")
					{
						$bPropsColumn = true;
						continue;
					}
					elseif ($arHeader["id"] == "DELAY")
					{
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

		<div class="delayed_items_body">
			<?
			foreach ($arResult["GRID"]["ROWS"] as $k => $arItem):

				if ($arItem["DELAY"] == "Y" && $arItem["CAN_BUY"] == "Y"):
			?>
				<div class="delayed_items_body_item" id="<?=$arItem["ID"]?>">

					<div class="delayed_items_body_item_name">

					<?if ($bDelayColumn || $bDeleteColumn):?>
						<div class="i_bs_control">
							<?if ($bDeleteColumn):?>
								<a  class="i_bs_delete" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>"><?//=GetMessage("SALE_DELETE")?></a>
							<?endif?>
						</div>
					<?endif;

					foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

						if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE", "PRICE", "SUM", "DISCOUNT") )) // some values are not shown in columns in this template
							continue;

						if ($arHeader["id"] == "NAME"):
						?>
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

							<div class="item">
								<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a class="i_detail_page_url" href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
									<?=$arItem["NAME"]?><a class="i_buy_buttom ifright" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["add"])?>"><?=GetMessage("SALE_ADD_TO_BASKET")?></a>
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

											if ($isImgProperty):
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
																		if ($arItemProp["VALUE"] == $arSkuValue["NAME"] || $arItemProp["VALUE"] == $arSkuValue["XML_ID"])
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
								?>
								<input type="hidden" name="DELAY_<?=$arItem["ID"]?>" value="Y"/>
								<div class="iclear"></div>
							</div>
						</div>
						<?
						elseif ($arHeader["id"] == "QUANTITY"):
						?>
							<div class="custom">
								<span class="idnone"><?=getColumnName($arHeader)?>:</span>
								<div>
									<?echo $arItem["QUANTITY"];
										if (isset($arItem["MEASURE_TEXT"]))
											echo "&nbsp;".$arItem["MEASURE_TEXT"];
									?>
								</div>
							</div>
						<?
						elseif ($arHeader["id"] == "PRICE"):
						?>
							<div class="price">
								<?if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
									<div class="current_price"><?=$arItem["PRICE_FORMATED"]?></div>
									<div class="old_price"><?=$arItem["FULL_PRICE_FORMATED"]?></div>
								<?else:?>
									<div class="current_price"><?=$arItem["PRICE_FORMATED"];?></div>
								<?endif?>

								<?if (strlen($arItem["NOTES"]) > 0):?>
									<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
									<div class="type_price_value"><?=$arItem["NOTES"]?></div>
								<?endif;?>
							</div>
						<?
						elseif ($arHeader["id"] == "DISCOUNT"):
						?>
							<div class="custom">
								<span class="idnone"><?=getColumnName($arHeader)?>:</span>
								<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
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
								<?=$arItem[$arHeader["id"]]?>
							</div>
						<?
						endif;
					endforeach?>
				</div>
				<?
				endif;
			endforeach;
			?>
		</div>

	</div>
</div>
<?