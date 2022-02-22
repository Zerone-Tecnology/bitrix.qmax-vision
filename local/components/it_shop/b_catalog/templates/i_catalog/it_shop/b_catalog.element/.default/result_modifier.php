<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
$l = strtoupper(LANGUAGE_ID);
// ---------------------------------------------------------------------------------------------------- iLaB
if($arResult):

	// $arResult component_epilog.php
	global $APPLICATION;
	$cp = $this->__component; // объект компонента
	if (is_object($cp))
	{
		$cp->arResult['CACHE_MIN_PRICE']	= $arResult['MIN_PRICE'];
		$cp->arResult['CACHE_RELATED']		= $arResult['PROPERTIES'][$arParams['I_RELATED']]['VALUE'];
		$cp->SetResultCacheKeys(array('CACHE_MIN_PRICE','CACHE_RELATED'));
	}

	// I_MORE_PHOTO
	if(isset($arResult['PROPERTIES']['I_MORE_PHOTO']['VALUE']) && is_array($arResult['PROPERTIES']['I_MORE_PHOTO']['VALUE']))
		foreach($arResult['PROPERTIES']['I_MORE_PHOTO']['VALUE'] as $FILE)
		{
			$FILE = CFile::GetFileArray($FILE);
			if(is_array($FILE))
				$arResult['MORE_PHOTO'][]=$FILE;
		}

	if( $arResult['DETAIL_PICTURE'] )
		array_unshift($arResult['MORE_PHOTO'], $arResult['DETAIL_PICTURE']);

	global $APPLICATION;
	$cp = $this->__component; // объект компонента
	$cp->SetResultCacheKeys(array('MORE_PHOTO'));

	if( $arResult['PROPERTIES']['I_VIDEO']['VALUE'] )
		foreach ($arResult['PROPERTIES']['I_VIDEO']['VALUE'] as $k=>$e)
			$arResult['PROPERTIES']['I_VIDEO']['I_VALUE'][] = array('VIDEO'=>$arResult['PROPERTIES']['I_VIDEO']['DESCRIPTION'][$k],'NAME'=>$e);

	// Отзывы
	$arSelect			= Array('ID', 'IBLOCK_ID', 'NAME', 'DETAIL_TEXT', 'DATE_CREATE');
	$arFilter			= Array('IBLOCK_ID'=>$arParams['REVIEW_IBLOCK_ID'], 'ACTIVE'=>'Y', 'PROPERTY_PRODUCT'=>$arResult['ID']);
	$arNavStartParams	= false;//Array('nPageSize'=>2);
	$res = CIBlockElement::GetList(Array('SORT'=>'ASC'), $arFilter, false, $arNavStartParams, $arSelect);
	while($ob = $res->GetNext())
	{
		// Сконвертируем дату формата 00 месяц 0000
		$i_date						= ParseDateTime($ob['DATE_CREATE'], FORMAT_DATETIME);
		$ob['I_DATE_CREATE']		= $i_date['DD'].' '.ToLower(GetMessage('MONTH_'.intval($i_date['MM']).'_S')).' '.$i_date['YYYY'];

		$arResult['I_REVIEWS'][]	= $ob;
	}

	// Количество
	if( $arParams['I_CHECK_QUANTITY']=='Y' && $arParams['I_QUAN_VERY_LITTLE'] && $arParams['I_QUAN_LITTLE'] && $arParams['I_QUAN_AVERAGE'] ):
		if( $arResult['CATALOG_QUANTITY']>0 && $arResult['CATALOG_QUANTITY']<($arParams['I_QUAN_VERY_LITTLE']+1) ) {
			$arResult['I_QUAN_PERC'] = '7';
			$arResult['I_QUAN_TEXT'] = GetMessage('QUAN_VERY_LITTLE');
		} elseif( $arResult['CATALOG_QUANTITY']>$arParams['I_QUAN_VERY_LITTLE'] && $arResult['CATALOG_QUANTITY']<($arParams['I_QUAN_LITTLE']+1) ) {
			$arResult['I_QUAN_PERC'] = '14';
			$arResult['I_QUAN_TEXT'] = GetMessage('QUAN_LITTLE');
		} elseif( $arResult['CATALOG_QUANTITY']>$arParams['I_QUAN_LITTLE'] && $arResult['CATALOG_QUANTITY']<($arParams['I_QUAN_AVERAGE']+1) ) {
			$arResult['I_QUAN_PERC'] = '21';
			$arResult['I_QUAN_TEXT'] = GetMessage('QUAN_AVERAGE');
		} elseif($arResult['CATALOG_QUANTITY']>$arParams['I_QUAN_AVERAGE'] ) {
			$arResult['I_QUAN_PERC'] = '28';
			$arResult['I_QUAN_TEXT'] = GetMessage('QUAN_MANY');
		} else {
			$arResult['I_QUAN_PERC'] = '0';
			$arResult['I_QUAN_TEXT'] = GetMessage('QUAN_NOT');
		}
	?>
	<style>
		.i_quan_sl:before { width: <?=$arResult['I_QUAN_PERC']?>px }
	</style>
	<?endif;

	// Языковые версии
	if( $arResult['PROPERTIES']['I_FULLNAME_'.$l]['VALUE'] )
		$arResult['NAME'] = $arResult['I_NAME_RU']['I_FULLNAME_'.$l]['VALUE'];
	elseif( $arResult['PROPERTIES']['I_NAME_'.$l]['VALUE'] )
		$arResult['NAME'] = $arResult['I_NAME_RU']['I_NAME_'.$l]['VALUE'];
endif;
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>