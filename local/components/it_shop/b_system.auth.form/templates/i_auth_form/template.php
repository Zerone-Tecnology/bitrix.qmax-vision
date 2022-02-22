<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$frame = $this->createFrame('j_m_auth', false)->begin();
$frame->setAnimation(true);?>

<div class="bx-system-auth-form">
<?if($arResult["FORM_TYPE"] == "login"):?>

<?
	if (CSite::InDir(SITE_DIR.'auth.php') || CSite::InDir(SITE_DIR.'personal/'))
	{
		ShowMessage($arResult['ERROR_MESSAGE']);
	}elseif ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'] && $arResult['ERROR_MESSAGE']['ERROR_TYPE'] == 'LOGIN')
	{
		echo '<div class="jq_auth_error">';
		$replace = str_replace('логин','E-mail',$arResult['ERROR_MESSAGE']);
		ShowMessage($replace);
		echo '</div>';
	}

?>

<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
	<table>
		<tr>
			<td colspan="2">
			<b><?=GetMessage("AUTH_LOGIN")?><span class="i_color_orange">*</span>:</b>
			<div class="i_auth_login"><input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" size="17" /></td></div>
		</tr>
		<tr>
			<td colspan="2">
			<div class="i_auth_password_title">
				<div class="i_auth_password_title_col">
					<b><?=GetMessage("AUTH_PASSWORD")?><span class="i_color_orange">*</span>:</b>
				</div>
				<div class="i_auth_password_title_col i_auth_password_title_col_2">
					<noindex><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex>
				</div>
			</div>
			<div class="i_auth_password">
			<input type="password" name="USER_PASSWORD" maxlength="50" size="17" />
<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>
<script type="text/javascript">
document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
</script>
<?endif?> </div>
			</td>
		</tr>
<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
		<tr>
			<td valign="top" width="1%"><input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" /></td>
			<td width="100%"><label class="i_remember_me" for="USER_REMEMBER_frm" title="<?=GetMessage("AUTH_REMEMBER_ME")?>"><span><?echo GetMessage("AUTH_REMEMBER_SHORT")?></span></label></td>
		</tr>
<?endif?>
<?if( $arParams['TERMS_OF_USE']=='Y' ):?>
			<tr>
				<td><input id="terms_of_use" type="checkbox"></td>
				<td><label for="terms_of_use"><?=GetMessage('TERMS_OF_USE_1')?></label> <a href="<?=SITE_DIR?>polzovatelskoe_soglashenie/"><?=GetMessage('TERMS_OF_USE_2')?></a></td>
			</tr>
<?endif?>
<?if ($arResult["CAPTCHA_CODE"]):?>
		<tr>
			<td colspan="2">
				<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:
				<div class="i_auth_captcha">
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
				<input type="text" name="captcha_word" maxlength="50" value="" />
				</div>
			</td>
		</tr>
<?endif?>
		<tr>
			<td colspan="2">
				<div class="i_auth_but_block">
					<div class="i_auth_but_block_col">
						<input type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />
					</div>
					<div class="i_auth_but_block_col i_auth_but_block_col_2">
						<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
							<noindex><a class="jq_registration" href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage('REGISTRATION')?></a></noindex>
						<?endif;?>
					</div>
				</div>
			</td>
		</tr>

<?if($arResult["AUTH_SERVICES"]):?>
		<tr>
			<td colspan="2">
				<div class="bx-auth-lbl"><?=GetMessage("socserv_as_user_form")?></div>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"SUFFIX"=>"form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
			</td>
		</tr>
<?endif?>
	</table>
</form>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"AUTH_URL"=>$arResult["AUTH_URL"],
		"POST"=>$arResult["POST"],
		"POPUP"=>"Y",
		"SUFFIX"=>"form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>

<?
//if($arResult["FORM_TYPE"] == "login")
else:
?>

<form action="<?=$arResult["AUTH_URL"]?>">
	<table width="95%">
		<tr>
			<td align="center">
				<?=$arResult["USER_NAME"]?><br />
				[<?=$arResult["USER_LOGIN"]?>]<br />
				<a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=GetMessage("AUTH_PROFILE")?></a><br />
			</td>
		</tr>
		<tr>
			<td align="center">
			<?foreach ($arResult["GET"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<input type="hidden" name="logout" value="yes" />
			<input type="submit" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" />
			</td>
		</tr>
	</table>
</form>
<?endif?>
</div>

<?$frame->beginStub()?>
	<div class="i_comp_loader"></div>
<?$frame->end()?>