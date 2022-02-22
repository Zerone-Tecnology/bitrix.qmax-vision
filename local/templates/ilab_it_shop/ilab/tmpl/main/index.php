<!-- [Index top] -->
<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_block_top.php',Array(),Array('MODE'=>'html', 'NAME'=>'Горизонтальный блок на главной', 'SHOW_BORDER'=>false));// Horizontal Block?>

<div class="i_special_offers_main">
	<div class="i_wr">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_special_offers_main.php',Array(),Array('MODE'=>'html', 'NAME'=>'Специальные предложения', 'SHOW_BORDER'=>false));// Special offers main?>
	</div>
</div>

<?/*
<!-- [Index bottom] -->
<div class="i_index_bottom">
	<div class="i_wr">
		<div class="i_index_bottom_left"><!-- Left Block -->
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_action.php',Array(),Array('MODE'=>'html', 'NAME'=>'Акции', 'SHOW_BORDER'=>false));// Action?>
		</div>
		<div class="i_index_bottom_right"><!-- Right Block -->
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_special_offers.php',Array(),Array('MODE'=>'html', 'NAME'=>'Специальные предложения', 'SHOW_BORDER'=>false));// Special offers?>
		</div>
	</div>
	<div class="i_index_bottom_wide">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_wide_special_offers.php',Array(),Array('MODE'=>'html', 'NAME'=>'Специальные предложения', 'SHOW_BORDER'=>false));// Special offers wide block?>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_wide_action.php',Array(),Array('MODE'=>'html', 'NAME'=>'Акции', 'SHOW_BORDER'=>false));// Action wide block?>
	</div>
</div>
*/?>
<!--НОВИНКИ-->
<div class="i_index_bottom">
	<div class="i_index_bottom_wide">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_wide_action.php',Array(),Array('MODE'=>'html', 'NAME'=>'Акции', 'SHOW_BORDER'=>false));// Action wide block?>
	</div>
</div>
<!--хиты продаж-->
<div class="i_index_bottom">
    <div class="i_index_bottom_wide">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_bestseller.php',Array(),Array('MODE'=>'html', 'NAME'=>'Акции', 'SHOW_BORDER'=>false));// Action wide block?>
    </div>
</div>
<!--БАНЕРЫ-->
<div class="i_catalog_links">
	<div class="i_wr">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_catalog_links.php',Array(),Array('MODE'=>'html', 'NAME'=>'Акции', 'SHOW_BORDER'=>false));// Action wide block?>
	</div>
</div>

<!--супер цена-->
<div class="i_index_bottom">
    <div class="i_index_bottom_wide">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_super-tsena2.php',Array(),Array('MODE'=>'html', 'NAME'=>'Супер цена', 'SHOW_BORDER'=>false));// Special offers wide block?>
    </div>
</div>

<div class="i_index_bottom">
	<div class="i_index_bottom_wide">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_wide_special_offers.php',Array(),Array('MODE'=>'html', 'NAME'=>'Специальные предложения', 'SHOW_BORDER'=>false));// Special offers wide block?>
	</div>
</div>


<?/*
<div class="i_act_new_wide">
	<div class="i_wr">
		<div class="i_new_wide">
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_news_wide.php',Array(),Array('MODE'=>'html', 'NAME'=>'Новости', 'SHOW_BORDER'=>false));// News wide?>
		</div>
		<div class="i_action_wide">
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_action_wide.php',Array(),Array('MODE'=>'html', 'NAME'=>'Акции', 'SHOW_BORDER'=>false));// Action wide?>
		</div>
	</div>
</div>
*/?>

<div class="i_actions_news_wide">
	<div class="i_wr">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_action_news.php',Array(),Array('MODE'=>'html', 'NAME'=>'Акции/Новости', 'SHOW_BORDER'=>false));// News\Action wide?>
	</div>
</div>

<div class="i_bv aclear">
	<div class="i_wr">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_video_swiper.php',Array(),Array('MODE'=>'html', 'NAME'=>'Баннер/Видео', 'SHOW_BORDER'=>false));// Banner/Video?>
	</div>
</div>

<div class="i_teaser_b_wrap">
	<div class="i_wr">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_teaser_bottom.php',Array(),Array('MODE'=>'html', 'NAME'=>'Нижний тизер', 'SHOW_BORDER'=>false));// Bottom teasers?>
	</div>
</div>
<div class="i_bv aclear">
	<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_banner_video.php',Array(),Array('MODE'=>'html', 'NAME'=>'Баннер/Видео', 'SHOW_BORDER'=>false));// Banner/Video?>
</div>
<div class="i_seo">
	<div class="i_wr">
		<div class="i_seo_flex">
			<div class="i_seo_logo"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/i_seo_logo.php',Array(),Array('MODE'=>'html', 'NAME'=>'Логотип в Seo блоке', 'SHOW_BORDER'=>true));// Seo logo?></div>
			<div class="i_seo_content"><?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/inc/'.LANGUAGE_ID.'/i_seo.php',Array(),Array('MODE'=>'html', 'NAME'=>'Seo блок', 'SHOW_BORDER'=>true));// Seo block?></div>
		</div>
	</div>
</div>