<?
$ll = explode(',', $arResult['ITEMS'][0]['PRO']['YANDEX_MAP']['VALUE']);
$lat = $ll[0];
$lng = $ll[1];
if($lat && $lng):?>
	<script src="//api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<?endif?>