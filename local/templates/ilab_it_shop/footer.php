

</div>

			<?if( $internal ):?>

						<?if( !$catalog ):?>
								</div>
								<?if( !$APPLICATION->GetDirProperty('i_menu') ):?>
									<div class="i_rwork i_w220 i_lwork_right ifright">
										<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/rwork.php',Array(),Array('MODE'=>'html', 'NAME'=>'Левая область', 'SHOW_BORDER'=>false))?>
									</div>
								<?endif?>
							</div>
						<?endif?>


					</div>
				</div>

			<?endif?>

			<?if(!CSite::InDir(SITE_DIR.'index.php') && !CSite::InDir(SITE_DIR.'personal/')):?>
				<?$viewProductIds = Ilab\Ok\viewed::getProductIds(['SECTION_ELEMENT_ID'=>$I_VIEW_ELEMENT_ID, 'PAGE_ELEMENT_COUNT'=>9]);
				if($viewProductIds):?>
					<div class="i_viewed_items_typical_block">
						<div class="i_wr">
							<div class="i_mt25 i_viewed_items">
								<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_wide_viewed.php',['I_VIEW_PRODUCT_IDS'=>$viewProductIds],['MODE'=>'html', 'NAME'=>'Баннер/Видео', 'SHOW_BORDER'=>false]);// Viewed?>
							</div>
						</div>
					</div>
				<? endif;?>
			<?endif?>

			<?if(!CSite::InDir(SITE_DIR.'personal/')):?>
				<div class="i_postfooter_block">
					<div class="i_wr">
						<div class="i_partners">
							<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_partners_swiper.php',Array(),Array('MODE'=>'html', 'NAME'=>'Партнеры', 'SHOW_BORDER'=>false));// Partners?>
						</div>
						<?/*
                        <div class="i_subscribe_block">
							<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/i_subscribe_form.php',Array(),Array('MODE'=>'html', 'NAME'=>'Подписка на рассылку', 'SHOW_BORDER'=>false));// Subscribe form?>
						</div>
                        */?>
					</div>
				</div>
			<?endif;

			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/'.$tmpl.'/footer.php',Array(),Array('MODE'=>'html', 'NAME'=>'Шапка сайта', 'SHOW_BORDER'=>false));// Footer?>

		</div>

		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/modal.php',Array(),Array('MODE'=>'html', 'NAME'=>'Модальное окно', 'SHOW_BORDER'=>false));// Modal window?>

		<?//<div class="i_up j_up idn"></div>?>

		<?// ---------------------------------------------------------------------------------------------------- BODY AFTER
		Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID('body_after')?>
		<div class="i_body_after"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/tmpl/body_after.php',Array(),Array('MODE'=>'php', 'NAME'=>'body after', 'SHOW_BORDER'=>false));// After?></div>
		<?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID('body_after','')
		// ---------------------------------------------------------------------------------------------------- BODY AFTER
		?>

	</body>

</html>