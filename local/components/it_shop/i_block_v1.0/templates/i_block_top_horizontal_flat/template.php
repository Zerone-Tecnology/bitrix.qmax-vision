<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
use Ilab\Core;
Core\CVariablesStorage::set('CIBLockTemplate', 'i_block_top_horizontal_flat');
  // ---------------------------------------------------------------------------------------------------- iLaB?>

<div class="i_h_menu">
	<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_h_menu.php',Array(),Array('SHOW_BORDER'=>false))// horizontal?>
</div>

<div class="i_index_top i_block_top_horizontal_flat">
	<div class="iclear">
		<div class="i_h_pro_day_wrap" id="jq_get_disc"><!-- Left Block -->
			<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_pro_day.php',Array(),Array('MODE'=>'html', 'NAME'=>'Товар дня', 'SHOW_BORDER'=>false));// Get a discount?>
			<?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_get_disc.php',Array(),Array('MODE'=>'html', 'NAME'=>'Получить скидку', 'SHOW_BORDER'=>false));// Get a discount?>
		</div>
		<div class="i_h_banner_wrap"><!-- Right Block -->
			<?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search.php',Array(),Array('MODE'=>'html', 'NAME'=>'Поиск', 'SHOW_BORDER'=>false));// Search
			$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_banner.php',Array(),Array('MODE'=>'html', 'NAME'=>'Баннер', 'SHOW_BORDER'=>false));// Banner?>
		</div>
	</div>
	<div class="iclear">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_teaser_top_flat.php',Array(),Array('MODE'=>'html', 'NAME'=>'Верхний тизер', 'SHOW_BORDER'=>false));// Top teasers?>
		<?//$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_teaser_top.php',Array(),Array('MODE'=>'html', 'NAME'=>'Верхний тизер', 'SHOW_BORDER'=>false));// Top teasers?>
	</div>
	<div class="iclear"></div>
</div>

<?// ---------------------------------------------------------------------------------------------------- iLaB?>