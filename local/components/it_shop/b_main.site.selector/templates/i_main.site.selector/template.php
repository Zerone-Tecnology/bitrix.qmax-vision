<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['SITES']):?>

	<div class="i_site_select ifleft">
		<?foreach ($arResult['SITES'] as $key => $arSite):
			if ($arSite['CURRENT'] == 'Y'):?>
				<span class="i_sise ibold" title="<?=$arSite['NAME']?>"><?=$arSite['NAME']?></span>
			<?else:?>
				<a class="i_sise" href="<?if(is_array($arSite['DOMAINS']) && strlen($arSite['DOMAINS'][0]) > 0 || strlen($arSite['DOMAINS']) > 0):?>http://<?endif?><?=(is_array($arSite['DOMAINS']) ? $arSite['DOMAINS'][0] : $arSite['DOMAINS'])?><?=$arSite['DIR']?>" title="<?=$arSite['NAME']?>"><span><?=$arSite['NAME']?></span></a>
			<?endif;
		endforeach?>
	</div>

<?endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>