<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$this->setFrameMode(true);
// Нельзя просто так взять и подключить карты :)
// Не включать КЭШ компоненты!
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult['ITEMS']):
	$l = strtoupper(LANGUAGE_ID);
	foreach($arResult['ITEMS'] as $k=>$e):?>
		<div class="i_fmap_div jq_fmap_div<?if($k>0)echo ' ivhid'?> ifont110" jq_id="<?=$e['ID']?>">
			<div class="i_fmap_txt"><?=$e['PREVIEW_TEXT']?></div>
			<div id="yandex_map" class="i_fmap_map jq_fmap_map" style="width: 100%; height: 360px;">
				<?/*foreach($e['D_PRO'] as $ie)
				{
					if( ($ie['USER_TYPE'] == ('map_yandex' || 'map_google')) && $ie['VALUE'] )
						echo $ie['DISPLAY_VALUE'];
				}*/?>
				<?//=$e['I_MAP']//=$e['D_PRO']['GOOGLE_MAP']['DISPLAY_VALUE']?>
			</div>
		</div>
	<?endforeach?>
	<?foreach($arResult['ITEMS'] as $k=>$e):?>
	<div href="/contact/" class="i_fmap_a jq_fmap_a<?if($k==0)echo ' i_fmap_activ'?>" jq_id="<?=$e['ID']?>">
		<span><?=$e['NAME']?></span>
	</div>
<?endforeach;?>
	<?$p_yandex_2 = explode(',', $arResult['ITEMS'][0]['PRO']['YANDEX_MAP']['VALUE']);?>
	<input type="hidden" class="j_map_init" data-city='{"id":<?=$arResult['ITEMS'][0]['ID']?>, "zoom":"16", "lat":"<?=$p_yandex_2[0]?>", "lng":"<?=$p_yandex_2[1]?>"}'
		   data-shops='<?=json_encode($arResult['MAP_PLACEMARKS'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT)?>'>
<?endif;
	/*if($USER->isAdmin()){
		echo '<pre class="ipre">';
			print_r($arResult);
		echo '</pre>';
	}*/
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>