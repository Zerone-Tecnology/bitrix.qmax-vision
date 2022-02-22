<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Iblock;
if(!Bitrix\Main\Loader::includeModule('iblock')) return;
// ---------------------------------------------------------------------------------------------------- iLaB
if( $arResult['ITEMS'] ):

	foreach($arResult['ITEMS'] as $k=>$e)
	{
// -------------------------------------------------- PROPERTY
		$arId[$e['ID']] = '';
// -------------------------------------------------- IMG BLock
		if( $e['PREVIEW_PICTURE'] )
			$img = $e['PREVIEW_PICTURE']['SRC'];
		elseif( $e['DETAIL_PICTURE'] )
			$img = $e['DETAIL_PICTURE']['SRC'];
		else
			$img = SITE_TEMPLATE_PATH.'/ilab/img/nophoto.png';

		$arResult['ITEMS'][$k]['I_PICTURE'] = $img;
	}

// -------------------------------------------------- DEFAULT no props
	$arParams['I_PROPERTY_CODE'] = array('CML2_LINK', 'I_INSTRUCTION', 'MINIMUM_PRICE', 'MAXIMUM_PRICE', 'I_VIDEO', 'I_RECOMMEND', 'I_MULTI_PRICE', 'I_PRO_DAY');
// -------------------------------------------------- PROPERTY
	$propertyIterator = Iblock\PropertyTable::getList(Array(
		'select'	=> array('ID', 'IBLOCK_ID', 'NAME', 'CODE', 'PROPERTY_TYPE'),
		'filter'	=> array('=IBLOCK_ID'=>$arParams['IBLOCK_ID'], '=ACTIVE'=>'Y', '!=PROPERTY_TYPE'=>Iblock\PropertyTable::TYPE_FILE, '!=CODE'=>$arParams['I_PROPERTY_CODE']),//'=CODE'=>'I_!%'
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
	<pre><?print_r($arResult)?></pre>
<?endif*/?>
