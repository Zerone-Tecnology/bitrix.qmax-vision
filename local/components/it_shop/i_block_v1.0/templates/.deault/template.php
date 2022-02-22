<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
  // ---------------------------------------------------------------------------------------------------- iLaB?>

<div class="i_h_menu">
	<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_h_menu.php',Array(),Array('SHOW_BORDER'=>false))// horizontal?>
</div>

<div class="i_index_top">
	<div>
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_search.php',Array(),Array('MODE'=>'html', 'NAME'=>'Поиск', 'SHOW_BORDER'=>false));// Search
		$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_banner.php',Array(),Array('MODE'=>'html', 'NAME'=>'Баннер', 'SHOW_BORDER'=>false));// Banner?>
	</div>
	<div class="iclear">
		<?$APPLICATION->IncludeFile(SITE_TEMPLATE_PATH.'/ilab/comp/'.LANGUAGE_ID.'/i_teaser_top.php',Array(),Array('MODE'=>'html', 'NAME'=>'Верхний тизер', 'SHOW_BORDER'=>false));// Top teasers?>
	</div>
	<div class="iclear"></div>
</div>

<?// ---------------------------------------------------------------------------------------------------- iLaB?>