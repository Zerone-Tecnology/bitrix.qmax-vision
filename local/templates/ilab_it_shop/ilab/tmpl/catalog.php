<!-- [Index top] -->
<div class="i_index_top">
	<div class="i_wr">
		<div class="ifleft i_w220"><!-- Left Block -->
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_v_menu.php',Array(),Array('MODE'=>'html', 'NAME'=>'Вертикальное меню каталога', 'SHOW_BORDER'=>false));// Vertical catalog menu?>
		</div>
		<div class="ifright i_w705"><!-- Right Block -->
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search.php',Array(),Array('MODE'=>'html', 'NAME'=>'Поиск', 'SHOW_BORDER'=>false));// Search
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_banner.php',Array(),Array('MODE'=>'html', 'NAME'=>'Баннер', 'SHOW_BORDER'=>false));// Banner
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_catalog.php',Array(),Array('MODE'=>'html', 'NAME'=>'Каталог', 'SHOW_BORDER'=>false));// Catalog?>
		</div>
	</div>
</div>