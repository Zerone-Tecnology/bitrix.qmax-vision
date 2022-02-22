<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
    <div id="basket_items_not_available" class="bx_ordercart_order_table_container" style="display:none">
        <table>

            <thead>
            <tr>
                <td><div class="basket_items_row">
						<?
						foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

						if ( in_array($arHeader["id"], array("TYPE", "QUANTITY", "SUM", "DISCOUNT")) ) // some header columns are shown differently
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
                        <div class="basket_items_col item" colspan="3" id="col_<?=getColumnId($arHeader)?>">
							<?
                            elseif ($arHeader["id"] == "PRICE"):
							?>
                            <div class="basket_items_col price" id="col_<?=getColumnId($arHeader)?>">
								<?
								else:
								?>
                                <div class="basket_items_col custom" id="col_<?=getColumnId($arHeader)?>">
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

				if (isset($arItem["NOT_AVAILABLE"]) && $arItem["NOT_AVAILABLE"] == true):
					?>
                    <tr><td>
                            <div class="i_b_item_top_bl">
                                <div class="bx_ordercart_itemtitle">
									<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?><a href="<?=$arItem["DETAIL_PAGE_URL"] ?>"><?endif;?>
										<?=$arItem["NAME"]?>
										<?if (strlen($arItem["DETAIL_PAGE_URL"]) > 0):?></a><?endif;?>
                                </div>
                            </div>
                            <div class="i_b_item_bl">
								<?

								foreach ($arResult["GRID"]["HEADERS"] as $id => $arHeader):

									if (in_array($arHeader["id"], array("PROPS", "DELAY", "DELETE", "TYPE", "QUANTITY", "SUM", "DISCOUNT") )) // some values are not shown in columns in this template
										continue;

									if ($arHeader["id"] == "NAME"):
										?>
                                        <div class="item col_<?=$arHeader['id']?>">
											<?
											if ($bDeleteColumn):
												?>
                                                <a  class="i_bs_delete" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["delete"])?>">
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

														echo htmlspecialcharsbx($val["NAME"]).":&nbsp;<span>".$val["VALUE"]."<span><br/>";
													endforeach;
												endif;
												?>
                                            </div>
											<?
											if (is_array($arItem["SKU_DATA"])):
												$propsMap = array();
												foreach ($arItem["PROPS"] as $propValue)
												{
													if (empty($propValue) || !is_array($propValue))
														continue;
													$propsMap[$propValue['CODE']] = (isset($propValue['~VALUE']) ? $propValue['~VALUE'] : $propValue['VALUE']);
												}
												unset($propValue);
												foreach ($arItem["SKU_DATA"] as $propId => $arProp):
													$selectedIndex = 0;
													// is image property
													$isImgProperty = false;
													if (!empty($arProp["VALUES"]) && is_array($arProp["VALUES"]))
													{
														$counter = 0;
														foreach ($arProp["VALUES"] as $id => $arVal)
														{
															$counter++;
															if (isset($propsMap[$arProp['CODE']]))
															{
																if ($propsMap[$arProp['CODE']] == $arVal['NAME'] || $propsMap[$arProp['CODE']] == $arVal['XML_ID'])
																	$selectedIndex = $counter;
															}
															if (isset($arVal["PICT"]) && !empty($arVal["PICT"]))
															{
																$isImgProperty = true;
															}
														}
														unset($counter);
													}
													$countValues = count($arProp["VALUES"]);
													$full = ($countValues > 5) ? "full" : "";

													$marginLeft = 0;
													if ($countValues > 5 && $selectedIndex > 5)
														$marginLeft = ((5 - $selectedIndex)*20).'%';

													if ($isImgProperty):
														?>
                                                        <div class="bx_item_detail_scu_small_noadaptive <?=$full?>">
															<span class="bx_item_section_name_gray">
																<?=htmlspecialcharsbx($arProp["NAME"])?>:
															</span>
                                                            <div class="bx_scu_scroller_container">
                                                                <div class="bx_scu">
                                                                    <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%; margin-left: <?=$marginLeft; ?>">
																		<?
																		$counter = 0;
																		foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
																			$counter++;
																			$selected = ($selectedIndex == $counter ? ' class="bx_active"' : '');
																			?>
                                                                            <li style="width:10%;"<?=$selected?>>
                                                                                <a href="javascript:void(0)" class="cnt"><span class="cnt_item" style="background-image:url(<?=$arSkuValue["PICT"]["SRC"]; ?>)"></span></a>
                                                                            </li>
																			<?
																		endforeach;
																		unset($counter);
																		?>
                                                                    </ul>
                                                                </div>
                                                                <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
                                                                <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
                                                            </div>

                                                        </div>
														<?
													else:
														?>
                                                        <div class="bx_item_detail_size_small_noadaptive <?=$full?>">
															<span class="bx_item_section_name_gray">
																<?=htmlspecialcharsbx($arProp["NAME"]);?>:
															</span>
                                                            <div class="bx_size_scroller_container">
                                                                <div class="bx_size">
                                                                    <ul id="prop_<?=$arProp["CODE"]?>_<?=$arItem["ID"]?>" style="width: 200%; margin-left: <?=$marginLeft; ?>;">
																		<?
																		$counter = 0;
																		foreach ($arProp["VALUES"] as $valueId => $arSkuValue):
																			$counter++;
																			$selected = ($selectedIndex == $counter ? ' class="bx_active"' : '');
																			?>
                                                                            <li style="width:10%;"<?=$selected?>>
                                                                                <a href="javascript:void(0);" class="cnt"><?=htmlspecialcharsbx($arSkuValue["NAME"]); ?></a>
                                                                            </li>
																			<?
																		endforeach;
																		unset($counter);
																		?>
                                                                    </ul>
                                                                </div>
                                                                <div class="bx_slide_left" onclick="leftScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
                                                                <div class="bx_slide_right" onclick="rightScroll('<?=$arProp["CODE"]?>', <?=$arItem["ID"]?>, <?=$countValues?>);"></div>
                                                            </div>
                                                        </div>
														<?
													endif;
												endforeach;
											endif;
											?>
                                            <input type="hidden" name="DELAY_<?=$arItem["ID"]?>" value="Y"/>
                                        </div>
										<?
                                    elseif ($arHeader["id"] == "QUANTITY"):
										?>
                                        <div class="basket_items_col custom">
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
										$price = i_price_currency_division($arItem["PRICE_FORMATED"]);
										?>
                                        <div class="basket_items_col custom price col_<?=$arHeader['id']?>">
                                            <span class="idnone"><?=getColumnName($arHeader)?>:</span>
                                            <div class="i_col_wrap basket_items_col_wrap">
                                                <div class="item-button">
                                                    <a class="i_buy_buttom" href="<?=str_replace("#ID#", $arItem["ID"], $arUrls["add"])?>"><?=GetMessage("SALE_ADD_TO_BASKET")?></a>
                                                </div>
                                                <div class="current_price_wrap">
													<?if (doubleval($arItem["DISCOUNT_PRICE_PERCENT"]) > 0):?>
                                                        <div class="old_price"><?=$arItem["FULL_PRICE_FORMATED"]?></div>
                                                        <div class="current_price"><?=$arItem["PRICE_FORMATED"]?></div>
													<?else:?>
                                                        <div class="current_price"><?=$price[0]?><span> <?=$price[1]?></span></div>
													<?endif?>

													<?/*if (strlen($arItem["NOTES"]) > 0):?>
											<div class="type_price"><?=GetMessage("SALE_TYPE")?></div>
											<div class="type_price_value"><?=$arItem["NOTES"]?></div>
											<?endif;*/?>
                                                </div>
                                            </div>
                                        </div>
										<?
                                    elseif ($arHeader["id"] == "DISCOUNT"):
										?>
                                        <div class="basket_items_col custom">
                                            <span class="idnone"><?=getColumnName($arHeader)?>:</span>
											<?=$arItem["DISCOUNT_PRICE_PERCENT_FORMATED"]?>
                                        </div>
										<?
                                    elseif ($arHeader["id"] == "WEIGHT"):
										?>
                                        <div class="basket_items_col custom">
                                            <span class="idnone"><?=getColumnName($arHeader)?>:</span>
											<?=$arItem["WEIGHT_FORMATED"]?>
                                        </div>
										<?
									else:
										?>
                                        <div class="basket_items_col custom">
                                            <span class="idnone"><?=getColumnName($arHeader)?>:</span>
											<?=$arItem[$arHeader["id"]]?>
                                        </div>
										<?
									endif;
								endforeach?>
                            </div>
                        </td>
                    </tr>
					<?
				endif;
			endforeach;
			?>
            </tbody>

        </table>
    </div>
<?