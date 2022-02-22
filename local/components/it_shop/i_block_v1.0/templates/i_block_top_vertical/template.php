<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use Ilab\Core;
Core\CVariablesStorage::set('IBLockTemplate', 'i_block_top_vertical');

$this->setFrameMode(true);
  // ---------------------------------------------------------------------------------------------------- iLaB?>

<div class="i_index_top i_block_top_vertical">
	<div class="i_wr">
		<div class="i_index_top_left"><!-- Left Block -->
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_v_menu.php',Array(),Array('MODE'=>'html', 'NAME'=>'Вертикальное меню каталога', 'SHOW_BORDER'=>false));// Vertical catalog menu?>
		</div>
		<div class="i_index_top_right"><!-- Right Block -->
			<?
			/*$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search.php',Array(),Array('MODE'=>'html', 'NAME'=>'Поиск', 'SHOW_BORDER'=>false));// Search*/
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_banner.php',Array(),Array('MODE'=>'html', 'NAME'=>'Баннер', 'SHOW_BORDER'=>false));// Banner
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_teaser_top.php',Array(),Array('MODE'=>'html', 'NAME'=>'Верхний тизер', 'SHOW_BORDER'=>false));// Top teasers?>
		</div>
	</div>
</div>

<?// ---------------------------------------------------------------------------------------------------- iLaB?>