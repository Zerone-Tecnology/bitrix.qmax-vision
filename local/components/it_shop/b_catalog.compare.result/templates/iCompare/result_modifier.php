<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Iblock;
if(!Bitrix\Main\Loader::includeModule('iblock')) return;
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult['ITEMS'] ):

	foreach($arResult['ITEMS'] as $k=>$e)
		$arResult['I_PRODUCT_ID'][] = $e['ID'];

	$arResult['I_BASE_CURRENCY'] = CCurrency::GetBaseCurrency();// Код базовой валюты.
// -------------------------------------------------- Measure
	$res = CCatalogMeasure::getList();
		while ($ob = $res->GetNext())
			$arResult['MEASURE'][$ob['ID']] = $ob;

	$res = CCatalogMeasureRatio::getList(
		array(),
		array('PRODUCT_ID' => $arResult['I_PRODUCT_ID']),
		false,
		false,
		array('PRODUCT_ID', 'RATIO')
	);
	while ($ob = $res->Fetch())
		$arResult['MEASURE_RATIO'][$ob['PRODUCT_ID']] = $ob['RATIO'];

	foreach($arResult['ITEMS'] as $k=>$e)
	{
// -------------------------------------------------- PROPERTY
		$arId[$e['ID']] = '';
// -------------------------------------------------- IMG BLock
		unset($img);

		if( $e['PREVIEW_PICTURE'] )
			$img = $e['PREVIEW_PICTURE']['SRC'];
		elseif( $e['DETAIL_PICTURE'] )
			$img = $e['DETAIL_PICTURE']['SRC'];
		else
			$img = SITE_TEMPLATE_PATH.'/ilab/img/nophoto.png';

		// MEASURE
		$arResult['ITEMS'][$k]['CATALOG_MEASURE_NAME']	= $arResult['MEASURE'][$e['CATALOG_MEASURE']]['SYMBOL_RUS'];
		$arResult['ITEMS'][$k]['~CATALOG_MEASURE_NAME']	= $arResult['MEASURE'][$e['CATALOG_MEASURE']]['~SYMBOL_RUS'];
		$arResult['ITEMS'][$k]['CATALOG_MEASURE_RATIO']	= $arResult['MEASURE_RATIO'][$e['ID']] ?? 1;

		$arResult['ITEMS'][$k]['I_PICTURE'] = $img;
		$arResult['I_PRODUCT_ID'][] = $e['ID'];
	}

// -------------------------------------------------- DEFAULT no props
	$ipc = [
		'CML2_LINK',
		'FORUM_TOPIC_ID',
		'ARFP',

		'MINIMUM_PRICE',
		'MAXIMUM_PRICE',

		'I_INSTRUCTION',
		'I_VIDEO',
		'I_RECOMMEND',
		'I_MULTI_PRICE',
		'I_PRO_DAY',

		'I_NAME_KZ',
		'I_NAME_EN',
		'I_NAME_RU',

		'I_FULLNAME_EN',
		'I_FULLNAME_KZ',
		'I_FULLNAME_RU',

		'ST_DISCOUNT',
		'ST_NEW',
		'ST_BESTSELLER',
		'ST_1_GIFT',
		'ST_OWN_BRANDS',

		'B_DISCOUNT',
		'B_NEW',
		'B_BESTSELLER',

		'M_DISCOUNT',
		'M_BESTSELLER',
		'M_NEW',

		'S_GIFT',
		'S_CREDIT',
		'S_ACTION',
		'S_BEST_PRICE'
	];

	if( $arParams['I_PROPERTY_CODE'] )
		$ipc = array_merge($ipc, $arParams['I_PROPERTY_CODE']);
// -------------------------------------------------- PROPERTY
	$propertyIterator = Iblock\PropertyTable::getList(Array(
		'select'	=> array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE'),
		'filter'	=> array('=IBLOCK_ID'=>$arParams['IBLOCK_ID'], '=ACTIVE'=>'Y', '!=PROPERTY_TYPE'=>Iblock\PropertyTable::TYPE_FILE, '!=CODE'=>$ipc),//'=CODE'=>'I_!%'
		'order'		=> array('SORT'=>'ASC', 'NAME'=>'ASC')
	));
	while($ob = $propertyIterator->fetch())
		$arResult['I_PROPERTY'][$ob['CODE']] = $ob;

	if( $arResult['I_PROPERTY'] )
		foreach($arResult['I_PROPERTY'] as $p)
			foreach($arResult['ITEMS'] as $k=>$e)
				if( $e['PROPERTIES'][$p['CODE']]['VALUE'] )
				{
					if( !$arResult['I_PRO'][$p['NAME']] )
						$arResult['I_PRO'][$p['NAME']] = $arId;

					$arResult['I_PRO'][$p['NAME']][$e['ID']] = $e['PROPERTIES'][$p['CODE']]['VALUE'];
				}

endif
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre class="ipre"><?print_r($arParams)?></pre>
<?endif*/?>
