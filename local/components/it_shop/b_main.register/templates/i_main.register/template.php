<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$frame = $this->createFrame('j_m_regi', false)->begin();
$frame->setAnimation(true);
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */?>
	<div class="bx-auth-reg">

		<?if($USER->IsAuthorized()):?>

			<p><?echo GetMessage('MAIN_REGISTER_AUTH')?></p>

		<?else:?>
			<?
			if (count($arResult['ERRORS']) > 0):
				foreach ($arResult['ERRORS'] as $key => $error)
					if (intval($key) == 0 && $key !== 0)
						$arResult['ERRORS'][$key] = str_replace('#FIELD_NAME#', '&quot;'.GetMessage('REGISTER_FIELD_'.$key).'&quot;', $error);
				echo '<div class="jq_reg_error">';
				ShowError(implode("<br />", $arResult["ERRORS"]));
				echo '</div>';

			elseif($arResult['USE_EMAIL_CONFIRMATION'] === 'Y'):
				?>
				<p><?echo GetMessage('REGISTER_EMAIL_WILL_BE_SENT')?></p>
			<?endif?>

			<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="regform" enctype="multipart/form-data">
				<?
				if($arResult['BACKURL'] <> ''):
					?>
					<input type="hidden" name="backurl" value="<?=$arResult['BACKURL']?>" />
					<?
				endif;
				?>

				<table>
					<tbody>
					<?foreach ($arResult['SHOW_FIELDS'] as $FIELD):?>
						<?if($FIELD == 'AUTO_TIME_ZONE' && $arResult['TIME_ZONE_ENABLED'] == true):?>
							<tr>
								<td colspan="2">
									<?=GetMessage('main_profile_time_zones_auto')?><?if ($arResult['REQUIRED_FIELDS_FLAGS'][$FIELD] == 'Y'):?><span class="starrequired">*</span><?endif?>
									<select name="REGISTER[AUTO_TIME_ZONE]" onchange="this.form.elements['REGISTER[TIME_ZONE]'].disabled=(this.value != 'N')">
										<option value=""><?echo GetMessage('main_profile_time_zones_auto_def')?></option>
										<option value="Y"<?=$arResult['VALUES'][$FIELD] == 'Y' ? " selected=\"selected\"" : ''?>><?echo GetMessage('main_profile_time_zones_auto_yes')?></option>
										<option value="N"<?=$arResult['VALUES'][$FIELD] == 'N' ? " selected=\"selected\"" : ''?>><?echo GetMessage('main_profile_time_zones_auto_no')?></option>
									</select>
								</td>
								<td></td>
							</tr>
							<tr>
								<td colspan="2">
									<?=GetMessage('main_profile_time_zones_zones')?>
									<select name="REGISTER[TIME_ZONE]"<?if(!isset($_REQUEST['REGISTER']['TIME_ZONE'])) echo 'disabled="disabled"'?>>
										<?foreach($arResult['TIME_ZONE_LIST'] as $tz=>$tz_name):?>
											<option value="<?=htmlspecialcharsbx($tz)?>"<?=$arResult['VALUES']['TIME_ZONE'] == $tz ? " selected=\"selected\"" : ''?>><?=htmlspecialcharsbx($tz_name)?></option>
										<?endforeach?>
									</select>
								</td>
								<td></td>
							</tr>
						<?else:?>
							<tr>
								<td>
									<b><?=GetMessage('REGISTER_FIELD_'.$FIELD)?></b>:<?if ($arResult['REQUIRED_FIELDS_FLAGS'][$FIELD] == 'Y'):?><span class="starrequired">*</span><?endif?><span class="i_auth_reg_note"><?=GetMessage('NOTE_'.$FIELD)?></span>
									<?
									switch ($FIELD)
									{
									case 'PASSWORD':
									?>
									<div class="i_auth_reg_inp">
										<input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult['VALUES'][$FIELD]?>" autocomplete="off" class="bx-auth-input" />
									</div>
									<?if($arResult['SECURE_AUTH']):?>
								</td>
								<td width="25px" valign="bottom">
				<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage('AUTH_SECURE_NOTE')?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
									<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage('AUTH_NONSECURE_NOTE')?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
									</noscript>
									<script type="text/javascript">
										document.getElementById('bx_auth_secure').style.display = 'inline-block';
									</script>
									<?endif?>
									<?
									break;
									case 'CONFIRM_PASSWORD':
										?>
										<div class="i_auth_reg_inp">
											<input size="30" type="password" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult['VALUES'][$FIELD]?>" autocomplete="off" />
										</div>
										<?
										break;

									case 'PERSONAL_GENDER':
										?><select name="REGISTER[<?=$FIELD?>]">
										<option value=""><?=GetMessage('USER_DONT_KNOW')?></option>
										<option value="M"<?=$arResult['VALUES'][$FIELD] == 'M' ? " selected=\"selected\"" : ''?>><?=GetMessage('USER_MALE')?></option>
										<option value="F"<?=$arResult['VALUES'][$FIELD] == 'F' ? " selected=\"selected\"" : ''?>><?=GetMessage('USER_FEMALE')?></option>
										</select><?
										break;

									case 'PERSONAL_COUNTRY':
									case 'WORK_COUNTRY':
										?><select name="REGISTER[<?=$FIELD?>]"><?
										foreach ($arResult['COUNTRIES']['reference_id'] as $key => $value)
										{
											?><option value="<?=$value?>"<?if ($value == $arResult['VALUES'][$FIELD]):?> selected="selected"<?endif?>><?=$arResult['COUNTRIES']['reference'][$key]?></option>
											<?
										}
										?></select><?
										break;

									case 'PERSONAL_PHOTO':
									case 'WORK_LOGO':
										?><input size="30" type="file" name="REGISTER_FILES_<?=$FIELD?>" /><?
										break;

									case 'PERSONAL_NOTES':
									case 'WORK_NOTES':
										?><textarea cols="30" rows="5" name="REGISTER[<?=$FIELD?>]"><?=$arResult['VALUES'][$FIELD]?></textarea><?
										break;
									default:
										if ($FIELD == 'PERSONAL_BIRTHDAY'):?><small><?=$arResult['DATE_FORMAT']?></small><br /><?endif;
										?>
										<div class="i_auth_reg_inp"><input size="30" type="text" name="REGISTER[<?=$FIELD?>]" value="<?=$arResult['VALUES'][$FIELD]?>" /></div>
										<?
										if ($FIELD == 'PERSONAL_BIRTHDAY')
											$APPLICATION->IncludeComponent(
												'bitrix:main.calendar',
												'',
												array(
													'SHOW_INPUT' => 'N',
													'FORM_NAME' => 'regform',
													'INPUT_NAME' => 'REGISTER[PERSONAL_BIRTHDAY]',
													'SHOW_TIME' => 'N'
												),
												null,
												array("HIDE_ICONS"=>"Y")
											);
										?><?
									}?>
								</td>
							</tr>
						<?endif?>
					<?endforeach?>
					<?// ********************* User properties ***************************************************?>
					<?if($arResult['USER_PROPERTIES']['SHOW'] == 'Y'):?>
						<tr><td colspan="2"><?=strlen(trim($arParams['USER_PROPERTY_NAME'])) > 0 ? $arParams['USER_PROPERTY_NAME'] : GetMessage('USER_TYPE_EDIT_TAB')?></td></tr>
						<?foreach ($arResult['USER_PROPERTIES']['DATA'] as $FIELD_NAME => $arUserField):?>
							<tr><td><?=$arUserField['EDIT_FORM_LABEL']?>:<?if ($arUserField['MANDATORY']=='Y'):?><span class="starrequired">*</span><?endif;?></td><td>
									<?$APPLICATION->IncludeComponent(
										"bitrix:system.field.edit",
										$arUserField["USER_TYPE"]["USER_TYPE_ID"],
										array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "regform"), null, array("HIDE_ICONS"=>"Y"));?></td></tr>
						<?endforeach;?>
					<?endif;?>
					<?// ******************** /User properties ***************************************************?>
					<?
					/* CAPTCHA */
					if ($arResult['USE_CAPTCHA'] == 'Y')
					{
						?>
						<tr>
							<td>
								<?/*
				<?=GetMessage('REGISTER_CAPTCHA_PROMT')?>
				<br>
				*/?>
								<input type="hidden" name="captcha_sid" value="<?=$arResult['CAPTCHA_CODE']?>" />
								<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult['CAPTCHA_CODE']?>" width="180" height="40" alt="CAPTCHA" />
							</td>
						</tr>
						<tr>
							<td>
								<b><?=GetMessage('REGISTER_CAPTCHA_TITLE')?></b>:<span class="starrequired">*</span>
								<div class="i_auth_reg_inp">
									<input type="text" name="captcha_word" maxlength="50" value="" />
								</div>
							</td>
						</tr>
						<?
					}
					/* !CAPTCHA */
					?>
					<?if( $arParams['TERMS_OF_USE']=='Y' ):?>
						<tr>
							<td><input class="jq_main_regi_tou" id="terms_of_use" type="checkbox"> <label for="terms_of_use"><?=GetMessage('TERMS_OF_USE_1')?></label> <a href="<?=SITE_DIR?>polzovatelskoe_soglashenie/"><?=GetMessage('TERMS_OF_USE_2')?></a><span class="starrequired">*</span></td>
						</tr>
					<?endif?>
					<tr>
						<td>
							<div class="i_auth_reg_block">
								<div class="i_auth_reg_block_col i_auth_reg_block_col_1">
									<input class="jq_main_regi" type="submit" name="register_submit_button" value="<?=GetMessage('AUTH_REGISTER')?>" />
								</div>
								<div class="i_auth_reg_block_col i_auth_reg_block_col_2">
									<span class="starrequired">*</span><?=GetMessage('AUTH_REQ')?>
								</div>
							</div>
						</td>
					</tr>

					</tbody>
				</table>
				<?/*<p><?=$arResult['GROUP_POLICY']['PASSWORD_REQUIREMENTS']?></p>*/?>

			</form>
		<?endif?>
	</div>

<?$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?$frame->end()?>