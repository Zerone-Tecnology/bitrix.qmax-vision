<footer class="i_footer iprel">
	<div class="i_footer_header">
		<div class="i_footer_header_left">
			<div class="i_fphone_tele"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_telephone.php',Array(),Array('MODE'=>'html', 'NAME'=>'Телефон', 'SHOW_BORDER'=>true));// Telephone?></div>
			<div class="i_fphone_mobi"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_mobphone.php',Array(),Array('MODE'=>'html', 'NAME'=>'Мобильный телефон', 'SHOW_BORDER'=>true));// Mobphone?></div>
		</div>
		<div class="i_address">
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_address.php',Array(),Array('MODE'=>'html', 'NAME'=>'Адрес', 'SHOW_BORDER'=>true));// Mobphone?>
			<div class="i_footer_map_wrap">
				<a href="<?=SITE_DIR?>contacts/" class="i_footer_map j_ad_fmap"><?=GetMessage('MAP')?></a>
				<?/*<div class="i_modal j_modal ipabs" id="j_ad_fmap">
					<div class="i_modal_tit" id="i_pos_ad_pay">
						<div class="jqm_pay"><?=GetMessage('M_ADDRESS_SHOP')?></div>
						<div class="i_modal_close j_modal_close ipabs"></div>
					</div>
					<div class="i_modal_in">
						<div class="jqm_map"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/m_address_shop.php',Array(),Array('MODE'=>'html', 'NAME'=>'Адреса магазинов', 'SHOW_BORDER'=>false))?></div>
					</div>
				</div>*/?>
			</div>
			<div class="i_femail"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/f_email.php',Array(),Array('MODE'=>'html', 'NAME'=>'email адрес', 'SHOW_BORDER'=>true));// Address?></div>
		</div>
	</div>
</footer>
<div class="i_footer_bottom">
	<div class="i_copy">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/i_copy.php',Array(),Array('MODE'=>'html', 'NAME'=>'Copyright', 'SHOW_BORDER'=>true));// Copy?>
		<div><?echo GetMessage('COPY').'&nbsp'.date('Y')?>.</div>
	</div>
	<div class="i_ilab"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/ilab.php',Array(),Array('MODE'=>'html', 'NAME'=>'ilab', 'SHOW_BORDER'=>false));// ilab?></div>
</div>

<?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/modal.php',Array(),Array('MODE'=>'html', 'NAME'=>'Модальное окно', 'SHOW_BORDER'=>false));// Modal window?>

<?
// ---------------------------------------------------------------------------------------------------- FCODE
Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('body_after')?>
<div class="i_fcode aclear"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/body_after.php',Array(),Array('MODE'=>'php', 'NAME'=>'Подключение различных сервисов/счетчиков', 'SHOW_BORDER'=>false));// FCODE?></div>
<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('body_after','')
// ---------------------------------------------------------------------------------------------------- FCODE?>