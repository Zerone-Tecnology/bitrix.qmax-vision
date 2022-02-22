<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);?>
<a name="tb"></a>
<a class="i_but_ou i_but_ou_profile_detail" href="<?=$arParams["PATH_TO_LIST"]?>"><?=GetMessage("SPPD_RECORDS_LIST")?></a>
<?if(strlen($arResult["ID"])>0):?>
	<?=ShowError($arResult["ERROR_MESSAGE"])?>
	<div class="i_profile_detail">
		<form method="post" action="<?=POST_FORM_ACTION_URI?>">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="ID" value="<?=$arResult["ID"]?>">
			<div class="sale_personal_profile_detail data-table">
				<div class="sale_personal_profile_detail_row">
					<div class="sale_personal_profile_detail_title">
						<h3><?= str_replace("#ID#", $arResult["ID"], GetMessage("SPPD_PROFILE_NO")) ?></h3>
					</div>
				</div>
				<div class="sale_personal_profile_detail_row">
					<div class="sale_personal_profile_detail_col"><?echo GetMessage("SALE_PERS_TYPE")?>:</div>
					<div class="sale_personal_profile_detail_col"><?=$arResult["PERSON_TYPE"]["NAME"]?></div>
				</div>
				<div class="sale_personal_profile_detail_row">
					<div class="sale_personal_profile_detail_col"><?echo GetMessage("SALE_PNAME")?>: <span class="req">*</span></div>
					<div class="sale_personal_profile_detail_col"><input type="text" name="NAME" value="<?echo $arResult["NAME"];?>" size="40"></div>
				</div>
				<?
				foreach($arResult["ORDER_PROPS"] as $val)
				{
					if(!empty($val["PROPS"]))
					{
						?>
						<div class="sale_personal_profile_detail_row">
							<div class="sale_personal_profile_detail_title"><h3><?=$val["NAME"]?></h3></div>
						</div>
						<?
						foreach($val["PROPS"] as $vval)
						{
							$currentValue = $arResult["ORDER_PROPS_VALUES"]["ORDER_PROP_".$vval["ID"]];
							$name = "ORDER_PROP_".$vval["ID"];
							?>
							<div class="sale_personal_profile_detail_row">
								<div class="sale_personal_profile_detail_col"><?=$vval["NAME"] ?>:
									<?if ($vval["REQUIED"]=="Y")
									{
										?><span class="req">*</span><?
									}
									?></div>
								<div class="sale_personal_profile_detail_col">
									<?if ($vval["TYPE"]=="CHECKBOX"):?>
										<input type="hidden" name="<?=$name?>" value="">
										<input type="checkbox" name="<?=$name?>" value="Y"<?if ($currentValue=="Y" || !isset($currentValue) && $vval["DEFAULT_VALUE"]=="Y") echo " checked";?>>
									<?elseif ($vval["TYPE"]=="TEXT"):?>
										<input type="text" size="<?echo (IntVal($vval["SIZE1"])>0)?$vval["SIZE1"]:30; ?>" maxlength="250" value="<?echo (isset($currentValue)) ? $currentValue : $vval["DEFAULT_VALUE"];?>" name="<?=$name?>">
									<?elseif ($vval["TYPE"]=="SELECT"):?>
										<select name="<?=$name?>" size="<?echo (IntVal($vval["SIZE1"])>0)?$vval["SIZE1"]:1; ?>">
											<?foreach($vval["VALUES"] as $vvval):?>
												<option value="<?echo $vvval["VALUE"]?>"<?if ($vvval["VALUE"]==$currentValue || !isset($currentValue) && $vvval["VALUE"]==$vval["DEFAULT_VALUE"]) echo " selected"?>><?echo $vvval["NAME"]?></option>
											<?endforeach;?>
										</select>
									<?elseif ($vval["TYPE"]=="MULTISELECT"):?>
										<select multiple name="<?=$name?>[]" size="<?echo (IntVal($vval["SIZE1"])>0)?$vval["SIZE1"]:5; ?>">
											<?
											$arCurVal = array();
											$arCurVal = explode(",", $currentValue);
											for ($i = 0; $i<count($arCurVal); $i++)
												$arCurVal[$i] = Trim($arCurVal[$i]);
											$arDefVal = explode(",", $vval["DEFAULT_VALUE"]);
											for ($i = 0; $i<count($arDefVal); $i++)
												$arDefVal[$i] = Trim($arDefVal[$i]);
											foreach($vval["VALUES"] as $vvval):?>
												<option value="<?echo $vvval["VALUE"]?>"<?if (in_array($vvval["VALUE"], $arCurVal) || !isset($currentValue) && in_array($vvval["VALUE"], $arDefVal)) echo" selected"?>><?echo $vvval["NAME"]?></option>
											<?endforeach;?>
										</select>
									<?elseif ($vval["TYPE"]=="TEXTAREA"):?>
										<textarea style="min-height: 100px" rows="<?echo (IntVal($vval["SIZE2"])>0)?$vval["SIZE2"]:4; ?>" cols="<?echo (IntVal($vval["SIZE1"])>0)?$vval["SIZE1"]:40; ?>" name="<?=$name?>"><?echo (isset($currentValue)) ? $currentValue : $vval["DEFAULT_VALUE"];?></textarea>
									<?elseif ($vval["TYPE"]=="LOCATION"):?>
										<?if ($arParams['USE_AJAX_LOCATIONS'] == 'Y'):
											$APPLICATION->IncludeComponent('bitrix:sale.ajax.locations', '', array(
												"AJAX_CALL" => "N",
												'CITY_OUT_LOCATION' => 'Y',
												'COUNTRY_INPUT_NAME' => $name.'_COUNTRY',
												'CITY_INPUT_NAME' => $name,
												'LOCATION_VALUE' => isset($currentValue) ? $currentValue : $vval["DEFAULT_VALUE"],
											),
												null,
												array('HIDE_ICONS' => 'Y')
											);
										else:
											?>
											<select name="<?=$name?>" size="<?echo (IntVal($vval["SIZE1"])>0)?$vval["SIZE1"]:1; ?>">
												<?foreach($vval["VALUES"] as $vvval):?>
													<option value="<?echo $vvval["ID"]?>"<?if (IntVal($vvval["ID"])==IntVal($currentValue) || !isset($currentValue) && IntVal($vvval["ID"])==IntVal($vval["DEFAULT_VALUE"])) echo " selected"?>><?echo $vvval["COUNTRY_NAME"]." - ".$vvval["CITY_NAME"]?></option>
												<?endforeach;?>
											</select>
											<?
										endif;
										?>
									<?elseif ($vval["TYPE"]=="RADIO"):?>
										<?foreach($vval["VALUES"] as $vvval):?>
											<input type="radio" name="<?=$name?>" value="<?echo $vvval["VALUE"]?>"<?if ($vvval["VALUE"]==$currentValue || !isset($currentValue) && $vvval["VALUE"]==$vval["DEFAULT_VALUE"]) echo " checked"?>><?echo $vvval["NAME"]?><br />
										<?endforeach;?>
									<?endif?>

									<?if (strlen($vval["DESCRIPTION"])>0):?>
										<br /><small><?echo $vval["DESCRIPTION"] ?></small>
									<?endif?>
								</div>
							</div>
							<?
						}
					}
				}
				?>
				<div class="sale_personal_profile_detail_row">
					<div class="sale_personal_profile_detail_col"></div>
					<div class="sale_personal_profile_detail_col">
						<input type="submit" name="save" value="<?echo GetMessage("SALE_SAVE") ?>">
						<?/*<input type="submit" name="apply" value="<?=GetMessage("SALE_APPLY")?>">
				<input type="submit" name="reset" value="<?echo GetMessage("SALE_RESET")?>">*/?>
					</div>
				</div>
			</div>
		</form>
	</div>
<?else:?>
	<?=ShowError($arResult["ERROR_MESSAGE"]);?>
<?endif;?>
