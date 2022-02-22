<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
// ---------------------------------------------------------------------------------------------------- iLaB
	\Bitrix\Main\Loader::includeModule('highloadblock');
	use Bitrix\Highloadblock as HL;
	use Bitrix\Main\Entity;
	use Bitrix\Main\Loader;
	use Bitrix\Currency\CurrencyTable;
	$l = strtoupper(LANGUAGE_ID);

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
	$cp->SetResultCacheKeys(array('MORE_PHOTO', 'OFFERS'));

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

	// MIN_OFFERS_PRICE
	if(is_array($arResult['OFFERS']) && !empty($arResult['OFFERS'])) //Product has offers
	{
		$minItemPrice					= 0;
		$minItemPriceFormat				= '';
		$arResult['CATALOG_QUANTITY']	= 0;// Колличество

		foreach($arResult['OFFERS'] as $arOffer)
		{
			$arResult['CATALOG_QUANTITY'] += $arOffer['CATALOG_QUANTITY'];// Колличество
			foreach($arOffer['PRICES'] as $code=>$arPrice)
			{
				if($arPrice['CAN_ACCESS'])
				{
					if ($arPrice['DISCOUNT_VALUE'] < $arPrice['VALUE'])
					{
						$minOfferPrice = $arPrice['DISCOUNT_VALUE'];
						$minOfferPriceFormat = $arPrice['PRINT_DISCOUNT_VALUE'];
					}
					else
					{
						$minOfferPrice = $arPrice['VALUE'];
						$minOfferPriceFormat = $arPrice['PRINT_VALUE'];
					}

					if ($minItemPrice > 0 && $minOfferPrice < $minItemPrice)
					{
						$minItemPrice = $minOfferPrice;
						$minItemPriceFormat = $minOfferPriceFormat;
					}
					elseif ($minItemPrice == 0)
					{
						$minItemPrice = $minOfferPrice;
						$minItemPriceFormat = $minOfferPriceFormat;
					}
				}
			}
		}
		if ($minItemPrice > 0)
		{
			$arResult['MIN_OFFER_PRICE'] = $minItemPrice;
			$arResult['PRINT_MIN_OFFER_PRICE'] = $minItemPriceFormat;
		}
	}

	// SKU
	if( $arParams['I_OFFER_TREE_PROPS'] && count($arResult['OFFERS'])> 0 )
	{
		// соберем сущности HL-блоков для выбранных свойств.
		$arHLT = array();
		$arHLE = array();
		$arHLN = array();
		foreach($arResult['OFFERS'] as $offers)
		{
			foreach($offers['PROPERTIES'] as $key => $ofprop)
			{
				if(in_array($key, $arParams['I_OFFER_TREE_PROPS'])
					&& strlen($ofprop['USER_TYPE_SETTINGS']['TABLE_NAME'])>0
					&& !in_array($ofprop['USER_TYPE_SETTINGS']['TABLE_NAME'], $arHLT))
				{
					$arHLT[] = $ofprop['USER_TYPE_SETTINGS']['TABLE_NAME'];
					$arResult['HL_TABLES'] = $arHLT;
				}
			}
		}

		// достанем элементы из HL если такие есть
		if(count($arHLT)>0)
		{
			foreach($arHLT as $hlname)
			{
				$hlblock	= HL\HighloadBlockTable::getList(array('filter'=>array('TABLE_NAME'=>$hlname)))->fetch();
				$entity		= HL\HighloadBlockTable::compileEntity($hlblock);
				$main_query	= new Entity\Query($entity);
				$main_query->setSelect(array('*'));
				$result		= $main_query->exec();
				$result		= new CDBResult($result);

				while ($row = $result->Fetch())
				{
					if(isset($row['UF_FILE']))
						$row['UF_FILE'] = CFile::GetPath($row['UF_FILE']);
					$arHLE[$hlname][$row['UF_XML_ID']]	= $row;
					$arHLN[$row['UF_NAME']]	= $row;
				}
			}
			$arResult['HL_ELEMENTS'] = $arHLE;
			$arResult['HL_ELEMNAME'] = $arHLN;
		}

		// соберем массив свойств для выбора
		$arHave	= array();
		$arFF	= '';
		foreach($arResult['OFFERS'] as $offers)
		{
			$arFF .=$offers['ID'].'^';
			foreach($offers['PROPERTIES'] as $key => $ofprop)
			{
				// соберем массив для вывода
				if(!in_array($ofprop['VALUE'], $arHave[$ofprop['ID']])
					&& in_array($key, $arParams['I_OFFER_TREE_PROPS'])
					&& strlen($ofprop['VALUE']) > 0)
				{
					$arPROPS['p'.$ofprop['ID']]['NAME'] = $ofprop['NAME'];

					if( strlen($ofprop['USER_TYPE_SETTINGS']['TABLE_NAME'])>0 || $arParams['I_OFFER_TREE_IMG']==$ofprop['CODE'] )
						$arPROPS['p'.$ofprop['ID']]['COLOR'] = 'Y';

					if(strlen($ofprop['USER_TYPE_SETTINGS']['TABLE_NAME']) > 0)
						$arPROPS['p'.$ofprop['ID']]['I_TREE'][] = array('NAME' => $arHLE[$ofprop['USER_TYPE_SETTINGS']['TABLE_NAME']][$ofprop['VALUE']]['UF_NAME'], 'VALUE'=>$arHLE[$ofprop['USER_TYPE_SETTINGS']['TABLE_NAME']][$ofprop['VALUE']]['UF_NAME'].'_'.$ofprop['ID'], 'URL'=> $arHLE[$ofprop['USER_TYPE_SETTINGS']['TABLE_NAME']][$ofprop['VALUE']]['UF_FILE']);
					elseif( $arParams['I_OFFER_TREE_IMG']==$ofprop['CODE'] )
						$arPROPS['p'.$ofprop['ID']]['I_TREE'][] = array('NAME' => $ofprop['VALUE'], 'URL'=> $arHLN[$ofprop['VALUE']]['UF_FILE'], 'VALUE'=>$ofprop['VALUE'].'_'.$ofprop['ID']);
					else
						$arPROPS['p'.$ofprop['ID']]['I_TREE'][] = array('NAME' => $ofprop['VALUE'], 'VALUE'=>$ofprop['VALUE'].'_'.$ofprop['ID']);

					$arHave[$ofprop['ID']][] = $ofprop['VALUE'];
				}
				// соберем массив товаров для фильтра
				if(in_array($key, $arParams['I_OFFER_TREE_PROPS']) && strlen($ofprop['VALUE']) > 0)
					if(strlen($ofprop['USER_TYPE_SETTINGS']['TABLE_NAME']) > 0)
						$arFF .= $arHLE[$ofprop['USER_TYPE_SETTINGS']['TABLE_NAME']][$ofprop['VALUE']]['UF_NAME'].'_'.$ofprop['ID'].'#';
					else
						$arFF .= $ofprop['VALUE'].'_'.$ofprop['ID'].'#';
			}
			$arFF .= '↕'; // alt+18
		}
		$arResult['I_SKU'] = $arPROPS;
		$arResult['I_SKU_FF'] = $arFF;
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
		$arResult['NAME'] = $arResult['PROPERTIES']['I_FULLNAME_'.$l]['VALUE'];
	elseif( $arResult['PROPERTIES']['I_NAME_'.$l]['VALUE'] )
		$arResult['NAME'] = $arResult['PROPERTIES']['I_NAME_'.$l]['VALUE'];

endif;
// ---------------------------------------------------------------------------------------------------- iLaB?>





<?/*if($USER->isAdmin()):?>
	<pre><?print_r($arResult)?></pre>
<?endif*/?>